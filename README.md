# Website-Forum
Simple MySQL and PHP forum.

# Table schemas

    CREATE TABLE categories(
      cat_id INT(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      cat_name VARCHAR(255) NOT NULL,
      cat_description VARCHAR(255) NOT NULL,
      UNIQUE INDEX cat_name_unqiue (cat_name)
      );

    CREATE TABLE topics(
      topic_id INT(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      topic_subject VARCHAR(255) NOT NULL,
      topic_date DATETIME NOT NULL,
      topic_cat INT(8) NOT NULL,
      topic_by INT(8) NOT NULL
      );

    CREATE TABLE posts (
      post_id INT(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      post_content TEXT NOT NULL,
      post_date DATETIME NOT NULL,
      post_topic INT(8) NOT NULL,
      post_by INT(8) NOT NULL
      );

    CREATE TABLE users (
      user_id INT(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      user_name VARCHAR(30) NOT NULL,
      user_pass VARCHAR(255) NOT NULL,
      user_email VARCHAR(255) NOT NULL,
      user_date DATETIME NOT NULL,
      user_level INT(8) NOT NULL,
      user_icon VARCHAR(255) NOT NULL,
      user_key VARCHAR(255) NOT NULL,
      user_confirmed INT(1) NOT NULL DEFAULT 0,
      user_about TEXT NOT NULL,
      UNIQUE INDEX user_name_unique (user_name)
      );

And some foreign keys...

    ALTER TABLE topics ADD FOREIGN KEY(topic_by) REFERENCES users(user_id) ON DELETE RESTRICT ON UPDATE CASCADE;
    ALTER TABLE posts ADD FOREIGN KEY(post_topic) REFERENCES topics(topic_id) ON DELETE CASCADE ON UPDATE CASCADE;
    ALTER TABLE posts ADD FOREIGN KEY(post_by) REFERENCES users(user_id) ON DELETE RESTRICT ON UPDATE CASCADE;
