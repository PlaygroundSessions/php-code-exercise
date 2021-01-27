### Docker for Windows, with PowerShell

This is the recommended approach to set up your development environment if you use Windows.

### Instructions

1. Ensure you have [Docker Desktop](https://www.docker.com/products/docker-desktop) installed.
   
1. Inside a blank folder, get the code for this exercise by using the Composer `create-project` command.

   ```
   docker run --rm --volume ${pwd}:/app composer create-project --prefer-dist playground-sessions/code-exercise .
   ```
   
1. Remove the `vendor\bin` directory, to avoid some weird, Windows-specific, symlink issues.  (Don't worry, we will recreate these later.)
   ```
   rm -r vendor/bin
   ```

1. Run docker compose, to create and run all the docker containers in this environment.

   Before running this command, make sure that any services (eg. Apache, Nginx, etc.) which normally listen
   on ports 80, 443, 3306, 6379, or 9000 are not running.
   ```
   docker-compose up -d --build
   ```
   
1. Recreate your `vendor\bin` folder, by running `composer install` from the container.
   ```
   docker run --rm --volume ${pwd}:/app composer install
   ```

1. You should now see the text `Lumen (8.2.1) (Laravel Components ^8.0)` at [http://localhost](http://localhost)

1. Initialize a git repository, and create an initial commit.

1. It should take about 2 seconds to load [http://localhost/student-progress/1](http://localhost/student-progress/1)

1. The development environment is all set up!

#### FAQs

1. How do I reset this docker setup, without losing any of my code?
    1. Stop and remove all the containers in this project.
       ```
       docker-compose down
       ```
    1. Remove symlinks, rebuild containers, and rebuild symlinks.
       ```
       rm -r vendor/bin
       docker-compose up -d --build
       docker run --rm --volume ${pwd}:/app composer install
       ```

1. How do I run vendor binaries, like phpunit?
   
   You can run vendor binaries like phpunit within the container.
   ```
   docker exec -it app-php /application/vendor/bin/phpunit
   ```
   To execute another binary, replace "phpunit" with the name of the binary.

1. Why can't I run vendor binaries from Windows?
   
   This is a result of the way NTFS handles symlinks.
   
   If you really want to do this,
   you can use the [alternate docker setup](alternative-docker.md).
   You will be able to run vendor binaries from both Windows and Docker containers, with that approach.
