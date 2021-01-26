## Do It Yourself

You can use a pre-existing development environment.

This might be the best option for you if you
- Do not want to use Docker and
- Are comfortable sharing your development environment with multiple projects.
  
These instructions assume you already have PHP, Composer, and MySQL installed

1. Inside a blank directory, get the code for this exercise by using the Composer `create-project` command.
   ```
   composer create-project --prefer-dist playground-sessions/code-exercise .   
   ```

1. Inside the `.env` file, change the environment variables for the database connection.
   ```
    DB_HOST
    DB_USERNAME
    DB_PASSWORD
   ```

1. Create a database named `playground`, and import the mysqldump from `docker/schema.sql`.

1. Serve the project locally, using the built-in PHP development server.
   ```
   php -S localhost:8000 -t public
   ```
   
1. You should now see the text `Lumen (8.2.1) (Laravel Components ^8.0)` at [http://localhost:8000](http://localhost:8000)

1. Initialize a git repository, and create an initial commit.

1. It should take about 2 seconds to load [http://localhost:8000/student-progress/1](http://localhost:8000/student-progress/1)

1. The development environment is all set up!
