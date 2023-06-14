-- CREATE DATABASE compartilhabytes COLLATE 'utf8_unicode_ci';

use compartilhabytes;

CREATE TABLE arquivos (
  id int(11) NOT NULL,
  nome_original varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  nome varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  descricao varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  criado_em datetime DEFAULT CURRENT_TIMESTAMP,
  user_id int(11) NOT NULL
);



CREATE TABLE comentarios (
  id int(11) NOT NULL,
  texto text COLLATE utf8_unicode_ci NOT NULL,
  arquivo_id int(11) NOT NULL,
  user_id int(11) NOT NULL
);


CREATE TABLE usuarios (
  id int(11) NOT NULL,
  nome varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  senha char(60) COLLATE utf8_unicode_ci NOT NULL,
  email varchar(255) COLLATE utf8_unicode_ci NOT NULL
);



ALTER TABLE arquivos
  ADD PRIMARY KEY (id),
  ADD KEY user_id (user_id);


ALTER TABLE comentarios
  ADD PRIMARY KEY (id),
  ADD KEY fk_user_id (user_id),
  ADD KEY arquivo_id (arquivo_id);


ALTER TABLE usuarios
  ADD PRIMARY KEY (id);


ALTER TABLE arquivos
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE comentarios
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE usuarios
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE arquivos
  ADD CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES usuarios (id);


ALTER TABLE comentarios
  ADD CONSTRAINT arquivo_id FOREIGN KEY (arquivo_id) REFERENCES arquivos (id),
  ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES usuarios (id);

