select*from invoice;
alter table invoice add column reimburse decimal(20,2);

select sum(reimburse) from invoice where date_part('year', invoice_date) = 2023 and date_part('month', invoice_date) = 06; 