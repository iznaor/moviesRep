# moviesRep
Demo project for movie news site

To locally launch the project you will have to have a php server and phpmyadmin installed and active
Details regarding connection to the database were not put into one php file so use this for your database:
$conn = new mysqli("localhost", "root", "2023", "moviesdb");
Or go through each file and manually change the details
Youtube links wont work in a local setup

What this project contains:
- navbar to navigate to other pages
- dark/light mode
- database for adding movies
- news segment for new articles
- simple comment section
- user page with basic info
- admin page from which new articles can be written or you can edit old ones

