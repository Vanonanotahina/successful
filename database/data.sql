create table benutzers(
    id serial,
    name varchar(50),
    email varchar(50),
    password varchar(50),
    pwd_md5 varchar(50) GENERATED ALWAYS AS (md5(password)) STORED,
    level int not null default 50,
    primary key(id)
);


create table patient(
    idp serial,
    name varchar(50),
    birthday date,
    gender char(2),
    reimburse boolean default false,
    primary key(idp) 
);

ALTER table patient ALTER column reimburse TYPE boolean;

create table spent(
    ids serial,
    type varchar(50),
    primary key(ids)
);

alter table spent add column budget decimal(11,2);
alter table spent add column code char(3);

insert into spent(type,budget,code) values('Loyer',1500000,'LOY');
insert into spent(type,budget,code) values('Reparation',200000,'REP');
insert into spent(type,budget,code) values('Salaire',350000,'SAL');

Tafita 0341897467

create table expenses(
    ide serial,
    spent_id int,
    date date,
    amount decimal(11,2),
    primary key(ide),
    foreign key(spent_id) references spent(ids)
);

create or replace view view_expenses as select s.*,e.* from expenses as e join spent as s on e.spent_id=s.ids;

create table actes(
    ida serial,
    type varchar(50),
    primary key(ida)
);

alter table actes add column budget decimal(11,2);
alter table actes add column code char(3);

insert into actes(type,budget,code) values('Consultation',2500000,'CON');
insert into actes(type,budget,code) values('Medicaments',250000,'MED');
insert into actes(type,budget,code) values('Analyse',383000,'ANL');


create table invoice(
    idi serial,
    patient_id int,
    invoice_date date,
    total decimal(11,2),
    primary key(idi),
    foreign key(patient_id) references patient(idp)
);

alter table invoice rename date to invoice_date;

create table activity(
    idac serial,
    acte_id int,
    invoice_id int,
    date date,
    amount decimal(11,2),
    primary key(idac),
    foreign key(acte_id) references actes(ida),
    foreign key(invoice_id) references invoice(idi)
);
alter table activity add column is_paid boolean not null default false;

alter table activity add column idac serial primary key;

insert into activity(acte_id,patient_id,date,amount) values(1,1,'2023/07/17',1000.00);
insert into activity(acte_id,patient_id,date,amount) values(2,1,'2023/07/17',15000.45);
insert into activity(acte_id,patient_id,date,amount) values(2,1,'2023/08/17',11560.25);
insert into activity(acte_id,patient_id,date,amount) values(2,1,'2022/08/17',560.25);

insert into activity(acte_id,patient_id,date,amount) values(1,2,'2023/07/17',100.00);
insert into activity(acte_id,patient_id,date,amount) values(2,2,'2023/07/17',23000.45);
insert into activity(acte_id,patient_id,date,amount) values(2,2,'2023/08/17',570.25);
insert into activity(acte_id,patient_id,date,amount) values(2,2,'2022/08/17',60.25);

-- where date_trunc('month', v.data_venda) = '2017-07-01'
where date_part('year', v.data_venda) = 2017
where v.data_venda >= '2017-07-01' and v_data_venda < '2017-08-01'

create or replace view view_expenses as select s.*,e.* from expenses as e join spent as s on e.spent_id=s.ids;

create or replace view view_activity as select ac.*,p.*,a.*,i.* from activity as a 
join actes as ac on a.acte_id = ac.ida 
join invoice as i on a.invoice_id=i.idi
join patient as p on i.patient_id = p.idp;

select date ,sum(amount) as recettes from  view_activity where date_part('year', date) = 2023 group by date;
select sum(amount) as recettes from  view_activity where date_part('month', date) = 08 and date_part('year', date) = 2023;
select sum(amount) as expenses from view_activity where patient_id = 1 group by patient_id;
select * from  view_activity where date_part('month', date) = 08 and date_part('year', date) = 2023;

    create or replace view activities_board as SELECT type,DATE_TRUNC('month', date) AS month, SUM(amount) AS total_amount,budget,(SUM(amount)*100)/budget as realisation
    FROM view_activity
    GROUP BY DATE_TRUNC('month', date),type,budget
    ORDER BY month;
    -- where date_part('year', date) = 2023

   create or replace view expenses_board as SELECT type,DATE_TRUNC('month', date) AS month, SUM(amount) AS total_amount,budget,(SUM(amount)*100)/budget as realisation
    FROM view_expenses
    GROUP BY DATE_TRUNC('month', date),type,budget
    ORDER BY month ;
     -- where date_part('year', date) = 2023
    -- and date_part('month', date) = 08



    select sum(total_amount) as total_reel,sum(budget) as total_budget,(sum(total_amount))/sum(budget) as realisation from activities_board
    where date_part('year', month) = 2023
    and date_part('month', month) = 10;


view(
    actes->type
    patient->name
    patient->birthday day
    patient->gender
    date    
    amount
);

decimal
javascript window.print (css skip div )
formatage date , valeur numerique

--------------------------------------------------------------


create table cats(
    idc serial,
    categorie varchar(30),
    primary key(idc)
);

create table places(
    idp serial,
    name varchar(30),
    id_cat int,
    primary key(idp),
    foreign key(id_cat) references cats(idc)
);


GROUP BY MONTH AND GOUP BY TYPE


SELECT type,DATE_TRUNC('month', date) AS month, SUM(amount) AS total_amount,budget,(SUM(amount)*100)/budget as realisation
FROM view_expenses
where date_part('year', date) = 2023
and date_part('month', date) = 07
GROUP BY DATE_TRUNC('month', date),type,budget
ORDER BY month ;

SELECT type,DATE_TRUNC('month', date) AS month, SUM(amount) AS total_amount,budget,(SUM(amount)*100)/budget as realisation
FROM view_activity
where date_part('year', date) = 2023
and date_part('month', date) = 07
GROUP BY DATE_TRUNC('month', date),type,budget
ORDER BY month;

select sum(total_amount) as total_reel,sum(budget) as total_budget,(sum(total_amount))/sum(budget) as realisation from expenses_board
where date_part('year', month) = 2023
and date_part('month', month) = 07;

select sum(total_amount) as total_reel,sum(budget) as total_budget,(sum(total_amount))/sum(budget) as realisation from activities_board
where date_part('year', month) = 2023
and date_part('month', month) = 07;