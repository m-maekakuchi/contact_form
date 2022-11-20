INSERT INTO genders(type) VALUES ('男');
INSERT INTO genders(type) VALUES ('女');

INSERT INTO contact(name, kana, tel, gender, email, content) VALUES ('前角地毬衣', 'マエカクチマリエ', '090-1234-5678', '女', 'test1@gmail.com', '商品はいつ届く予定ですか？');

-- gender列に外部キー制約をかけているので、以下のINSERT文は発行できない。
-- INSERT INTO contact(name, kana, tel, gender, email, content) VALUES ('前角地毬衣', 'マエカクチマリエ', '090-1234-5678', 1, 'test1@gmail.com', '商品はいつ届く予定ですか？');

INSERT INTO hobbys(hobby, contact_id) VALUES ('ショッピング', 1);
INSERT INTO hobbys(hobby, contact_id) VALUES ('読書', 1);
INSERT INTO hobbys(hobby, contact_id) VALUES ('ゲーム', 1);

SELECT * FROM contact c JOIN hobbys h ON c.id = h.contact_id WHERE c.id = 1;