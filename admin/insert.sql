insert into product values(null, 'バターピーナッツ', 200);




//価格が安い順 order by句
select * from product order by price;

//価格が高い順
select * from product order by price desc;

//検索結果を並べ替える場合、where句と組み合わせる
select * from product where name like '%ナッツ%' order by price;