{include file='header.tpl'}
{include file='menu.tpl' userid=$userid username=$username blogid=$blog.id blogownerid=$blog.userid userhasblog=$userhasblog}
<!-- CONTENT -->
	  <h1 class="title">Documentation</h1>
      
	  <h2 id="cont">Content</h2>
	  <ul>
	    <li><a href="#usr">Default users and passwords</a></li>
	    <li><a href="#dbs">Database schema</a></li>
		<li><a href="#how">How to use the application</a></li>
		<li><a href="#add">Additional notes and comments</a></li>
		<li><a href="#dis">Disclaimer</a></li>
	  </ul>
	  
	  <h2 id="usr">Default users and passwords</h2>
	  <p>
		Username1: John<br />
		Password1: 1234<br />
	  </p>
	  <p>
		Username2: Charles<br />
		Password2: 4567<br />
	  </p>
	  
	  <p style="text-align:right;">
	    <a href="#cont">back to Content</a>
	  </p>
	  
      <h2 id="dbs">Database schema</h2>
	  <p>
	    <code>
CREATE TABLE users (<br />
	id INT NOT NULL auto_increment,<br />
	username VARCHAR(30) NOT NULL UNIQUE,<br />
	password VARCHAR(40) NOT NULL,<br />
	name VARCHAR(80) NOT NULL,<br />
	email VARCHAR(80) NOT NULL UNIQUE,<br />
	PRIMARY KEY (id)<br />
) ENGINE =  InnoDB;<br />
<br />
CREATE TABLE blogs (<br />
	id INT NOT NULL auto_increment,<br />
	userid INT NOT NULL,<br />
	title VARCHAR(80) NOT NULL,<br />
	summary TEXT NOT NULL,<br />
	CREATEd TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,<br />
	PRIMARY KEY(id),<br />
	FOREIGN KEY (userid) REFERENCES users(id) ON DELETE CASCADE<br />
) ENGINE =  InnoDB;<br />
<br />
CREATE TABLE articles (<br />
    id INT NOT NULL auto_increment,<br />
    headline VARCHAR(80) NOT NULL,<br />
	userid INT NOT NULL,<br />
	article_body TEXT NOT NULL,<br />
	blogid INT NOT NULL,<br />
	CREATEd TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,<br />
    PRIMARY KEY (id),<br />
	FOREIGN KEY (userid) REFERENCES users(id) ON DELETE CASCADE,<br />
	FOREIGN KEY (blogid) REFERENCES blogs(id) ON DELETE CASCADE<br />
) ENGINE =  InnoDB;<br />
<br />
CREATE TABLE tags (<br />
	id INT NOT NULL auto_increment,<br />
	name VARCHAR(80) NOT NULL UNIQUE,<br />
	PRIMARY KEY (id)<br />
) ENGINE =  InnoDB;<br />
<br />
CREATE TABLE photos (<br />
	id INT NOT NULL auto_increment,<br />
	imagedata BLOB DEFAULT "",<br />
    imagename VARCHAR(40) DEFAULT "",<br />
    imagetype VARCHAR(40) DEFAULT "",<br />
    imagesize VARCHAR(40) DEFAULT "",<br />
	PRIMARY KEY (id)<br />
) ENGINE =  InnoDB;<br />
<br />
CREATE TABLE comments (<br />
	id INT NOT NULL auto_increment,<br />
	title VARCHAR(80) NOT NULL,<br />
	userid INT NOT NULL,<br />
	comment_text TEXT NOT NULL,<br />
	articleid INT NOT NULL,<br />
	created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,<br />
	PRIMARY KEY (id),<br />
	FOREIGN KEY (userid) REFERENCES users(id) ON DELETE CASCADE,<br />
	FOREIGN KEY (articleid) REFERENCES articles(id) ON DELETE CASCADE<br />
) ENGINE =  InnoDB;<br />
<br />
CREATE TABLE article_photo1 (<br />
	id INT NOT NULL auto_increment,<br />
	articleid INT NOT NULL,<br />
	photoid INT NOT NULL,<br />
	PRIMARY KEY (id),<br />
	FOREIGN KEY (articleid) REFERENCES articles(id) ON DELETE CASCADE,<br />
	FOREIGN KEY (photoid) REFERENCES photos(id) ON DELETE CASCADE<br />
) ENGINE =  InnoDB;<br />
<br />
CREATE TABLE article_tag1 (<br />
	id INT NOT NULL auto_increment,<br />
	articleid INT NOT NULL,<br />
	tagid INT NOT NULL,<br />
	PRIMARY KEY (id),<br />
	FOREIGN KEY (articleid) REFERENCES articles(id) ON DELETE CASCADE,<br />
	FOREIGN KEY (tagid) REFERENCES tags(id) ON DELETE CASCADE<br />
) ENGINE =  InnoDB;
		</code>
	  </p>
	  
	  <p style="text-align:right;">
	    <a href="#cont">back to Content</a>
	  </p>
	  
	  <h2 id="how">How to use the application</h2>
	  
	  <p>
	    The application, in my opinion, is very straight forward to use. Basically the user would need to use the menu on the left to navigate through the main areas of the webiste and if there are sub menus in a section, they will appear on top of the section title.
	  </p>
	  <p>
	    To create the layout, some principles of user interface design were used, let always the user know where is, where he can go and give feedback about his movements.
	  </p>
	  <p>
	    Basically, the <a href="index.php">homepage</a> of the application shows a list of all the blogs, showing the headline and his author, ordered to show the newest on top. Clicking on a headline will redirect to another page that shows the details of the article. This list is paginated, just to show it, the max article per page is set to 2, this can be changed in the file includes/functions.php modifying the constant ITEMS_PER_PAGE.
	  </p>
	  <p>
	    In the page that shows the details of an article, there is a sub menu where the user can update the article or delete it. Also, on the bottom, after the article body and author name, there are links to the different tags related to the article, clicking on any of the tags will redirect to a search of all the articles related to that tag. The last feature in this page, there are a previous and a next link on the bottom, this links helps the user to move from one article to another. Since this was not part of the assignment, only provides a limited interface, blocking the link when there are no more articles (before or after).
	  </p>
	  <p>
	    The search bar can be found in every page of the application (except in the documentation). It looks for any coincidence in either the headline or the body of an article or in the title or summary of a blog, depending which option is selected to look for in the drop down box. Also there is an option to search by a tag.
	  </p>
	  <p>
	    The different sections of the blog will open depending on the user that is logged, only the owner of a blog can post articles in it or modify the content of his articles.
	  </p>
	  <p>
	    To show the validation of a form, please proceed to <a href="register.php">register user</a> form (only accesable if there is not logged in user). This form checks with javascript that every input is correctly filled, the email doesn't accept a string that is not an email, the name has to be at least 2 characters, password must be at least 4 characters long and username must have at least 3 characters, only accepting alphanumeric, underscore and spaces for this last one, but cannot start or end with a space.
	  </p>
	  <p>
	    In the blog details page, there is a list of the 5 newest articles in that blog, because of this, the list doesn't need to be paginated. Still there is an option in the side menu to see every articles in the specific blog, this list is paginated.
	  </p>
	  <p>
	    I would recommend to look the following <a href="article.php?blogid=1&id=1">article</a>, this is the best example since it contains pictures and comments. Also it shares a picture with this other <a href="article.php?blogid=1&id=3">article</a>, which is stored only once in the database. Both articles are from the same blog to make it easier to go from one to another.
	  </p>
	  
	  <p style="text-align:right;">
	    <a href="#cont">back to Content</a>
	  </p>
	  
	  <h2 id="add">Additional notes and comments</h2>
	  
	  <p>
	    One more thing that I wanted to implement, but couldn't because of time, was to create a way to transmit the errors to the users. I started creating different constants with meanings that would be returned in case something was wrong. The idea was to capture this warnings with a javascript and output a message in an alert box depending on the meaning of this error number. The constants can be accesed in the file includes/functions.php
	  </p>

	  <p style="text-align:right;">
	    <a href="#cont">back to Content</a>
	  </p>
	  
	  <h2 id="dis">Disclaimer</h2>
	  
	  <p>
	    Website created for educational purpose only for Griffith University's Web Programming course.<br>
	  </p>
	  <p>
	    Created by: Jos&eacute; Gleiser<br>
		Email: {mailto address="jose.gleiser@gmail.com" encode="javascript" subject="WP - About Assignment 2"}
	  </p>
	  
	  <p style="text-align:right;">
	    <a href="#cont">back to Content</a>
	  </p>
	  
      <!-- END CONTENT -->
{include file='footer.tpl'}
