truncate patient cascade;
truncate activity cascade;
truncate expenses cascade;
truncate actes cascade;
truncate spent cascade;


create or replace view view_expenses as select s.*,e.* from expenses as e join spent as s on e.spent_id=s.ids;

create or replace view view_activity as select ac.*,p.*,a.*,i.* from activity as a 
join actes as ac on a.acte_id = ac.ida 
join invoice as i on a.invoice_id=i.idi
join patient as p on i.patient_id = p.idp;

create or replace view activities_board as SELECT type,DATE_TRUNC('month', date) AS month, SUM(amount) AS total_amount,budget,(SUM(amount)*100)/budget as realisation
FROM view_activity
GROUP BY DATE_TRUNC('month', date),type,budget
ORDER BY month;

create or replace view expenses_board as SELECT type,DATE_TRUNC('month', date) AS month, SUM(amount) AS total_amount,budget,(SUM(amount)*100)/budget as realisation
FROM view_expenses
GROUP BY DATE_TRUNC('month', date),type,budget
ORDER BY month ;


select sum(total_amount) as total_reel,sum((budget/12)) as total_budget,(sum(total_amount)/sum((budget/12)))*100 as realisation  from activities_board
where date_part('year', month) = 2023
and date_part('month', month) = 01;

select sum(total_amount) as total_reel,sum((budget/12)) as total_budget,(sum(total_amount)/sum((budget/12)))*100 as realisation  from expenses_board
where date_part('year', month) = 2023
and date_part('month', month) = 01;


SELECT type,DATE_TRUNC('month', date) AS month, SUM(amount) AS total_amount,(budget/12) as budget,(SUM(amount)/(budget/12))*100 as realisation
FROM view_activity
GROUP BY DATE_TRUNC('month', date),type,budget
ORDER BY month;





create view test as select*from actes;
select t.ida,t.type,va.budget from view_activity as va join test as t on va.ida=t.ida;
create view spent_view as select s.*,(budget/12) as mensuel from spent as s;
create view expenses_view as select*from expenses;
select sv.type,sv.mensuel,ev.amount,sv.ids from expenses_view as ev left join spent_view as sv on ev.spent_id=sv.ids group by sv.ids,sv.type,sv.mensuel,ev.amount;



select s.type, from expenses as e join spent as s on e.spent_id=s.ids; 





SELECT type,DATE_TRUNC('month', date) AS month, SUM(amount) AS total_amount,(budget/12) as budget,(SUM(amount)/(budget/12))*100 as realisation
FROM view_activity
where date_part('year', date) = 2023
and date_part('month', date) = 01
GROUP BY DATE_TRUNC('month', date),type,budget
ORDER BY month;