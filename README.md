# Playground Sessions Backend Code Exercise (Lumen)

## Scenario
Take this hypothetical situation.

We are making an app for teachers.
A teacher will select a student to see all lessons, and whether that student completed each lesson.

The apps will get their data from the JSON REST API endpoint:

```
/student-progress/{userId}
```

Where `{userId}` is the user id of the student.

You inherit this WIP codebase.

You remember how the data is structured in the database:
- Lessons are comprised of several segments.
- A user can create practice records for a segment.

You look over the codebase and realize that several problems exist in this endpoint.
1. The front-end data structures is coupled to the database structure.
1. Business rules (eg. whether a user has completed a lesson) would be duplicated by each app.
1. It is too slow, even with a reasonable amount of practice records.

Luckily, both front-end developers agree that the endpoint needs to change before it is used.
You all agree to the following data structure for the response:

```
{
  "lessons": [
    {
      "id": 32,
      "difficulty": "Rookie"
      "isComplete": true,
    }
  ]
}
```

## Instructions

Solve all three problems with this codebase.

- Create a separate data structure for the response.
- Codify the business rules.
  - A lesson is considered complete if a user has at least one practice record
with a score of 80%.
  - Difficulty categories ("Rookie", "Intermediate", "Advanced") are associated with difficulty numbers
    [1,2,3], [4,5,6], [7,8,9], respectively.
- Ensure the response time is under 100ms for the given dataset.  Right now it responds in about 2 seconds.

Code should be clean.
Code you write should follow the Single Responsibility Principle (SRP).
Code should be written in self-contained parts, each having one responsibility.
For example, application logic (eg. extracting query parameters from a URL)
should be separate from business logic (eg. determining if a required query parameter was supplied).

You have full reign over the codebase. You can add or remove any packages you like. 
For example, you could use a different ORM, or even a different framework, if you think that would be quicker for you.

Everything is fair game.

We are testing your ability to organize code cleanly, with SRP, not your knowledge of the Laravel/Lumen frameworks.

Try to commit often and with small changes, so we can see what you are doing.

If you have a particular strength (say documenting APIs), feel free show it off.

You might benefit from knowing that each of the 3 problems can be solved without 
needing to pre-calculate or cache results beforehand.

Like any other business request, there may be an edge case you encounter which could use some additional clarity
or maybe you are thinking about a particular approach, and you want some feedback.  Communication is key to good code.
Feel free to ask.

## Deliverables

Email ben@playgroundsessions.com with a link to your git repository.

## Getting Started

For your convenience,
we provide two approaches to quickly setup a fully operational development environment with php8.0-fpm, nginx, and mysql8.
- Docker for Windows or MacOS
- Ansible for Linux

Feel free to reach out with questions about setting up this environment.

### Docker for Windows, with PowerShell

1. Ensure you have [Docker Desktop](https://www.docker.com/products/docker-desktop) installed.
   
1. Inside a blank folder, get the code for this exercise by using the Composer `create-project` command.

   ```
   docker run --rm --volume ${pwd}:/app composer create-project --prefer-dist playground-sessions/code-exercise .
   ```
   
1. Remove the `vendor\bin` directory, to avoid some weird, Windows-specific, symlink bugs.  (Don't worry, we will recreate these later.)
   ```
   rm -r vendor/bin
   ```

1. Run docker compose, to create and run all the docker containers in this environment.
   
   Make sure that any services (eg. Apache, Nginx, etc.) which normally listen
   on ports 80, 443, 3306, 6379, or 9000 are not running.
   ```
   docker-compose up -d --build
   ```
   
1. Recreate your `vendor\bin` folder.
   ```
   docker run --rm --volume ${pwd}:/app composer install
   ```

1. You should now see the text `Lumen (8.2.1) (Laravel Components ^8.0)` at [http://localhost](http://localhost)

1. Initialize a git repository, and create an initial commit.

1. It should take about 2 seconds to load [http://localhost/student-progress/1](http://localhost/student-progress/1)

1. The development environment is all set up!

FAQs

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

### Docker for MacOS

1. Ensure you have [Docker Desktop](https://www.docker.com/products/docker-desktop) installed.
   
1. Inside a blank directory, get the code for this exercise by using the Composer `create-project` command.
   ```
   docker run --rm --volume $pwd:/app composer create-project --prefer-dist playground-sessions/code-exercise .
   ```

1. Run docker compose, from the root of the new `my-exercise` folder.

   Make sure that any services (eg. Apache, Nginx, etc.) which normally listen
   on ports 80, 443, 3306, 6379, or 9000 are not running.
   ```
   docker-compose up -d --build
   ``` 

1. You should now see the text `Lumen (8.2.1) (Laravel Components ^8.0)` at [http://localhost](http://localhost)

1. Initialize a git repository, and create an initial commit.

1. It should take about 2 seconds to load [http://localhost/student-progress/1](http://localhost/student-progress/1)

1. The development environment is all set up!

FAQs

1. How do I reset this docker setup, without losing any of my code?
    1. Stop and remove all the containers in this project.
   ```
   docker-compose down
   ```
    1. Rebuild containers.
   ```
   docker-compose up -d --build
   ```

1. How do I run vendor binaries, like phpunit?
   You can run vendor binaries like phpunit within the container.
   ```
   docker exec -it app-php /application/vendor/bin/phpunit
   ```
   To execute another binary, replace "phpunit" with the name of the binary.
   
### Ansible for Linux

These instructions are created for use with a fresh installation of Ubuntu 20.04.

1. Install ansible and composer.
   ```
   sudo apt install ansible composer
   ```
   
1. Inside a blank directory, get the code for this exercise by using the Composer `create-project` command.
   ```
   composer create-project --prefer-dist playground-sessions/code-exercise .   
   ```
   
1. Run the playbook.
   ```
   ansible-playbook ansible/setup-development-environment --ask-become-pass
   ```
   When asked, enter the password for sudo.

1. You can serve the project locally, using the built-in PHP development server.
   ```
   php -S localhost:8000 -t public
   ```

1. You should now see the text `Lumen (8.2.1) (Laravel Components ^8.0)` at [http://localhost:8000](http://localhost:8000)

1. Initialize a git repository, and create an initial commit.

1. It should take about 2 seconds to load [http://localhost:8000/student-progress/1](http://localhost:8000/student-progress/1)

1. The development environment is all set up!

[Do It Yourself](readme/diy.md)

### Additional Information

Your MySQL credentials have been randomized.  Should you want them, 
they are inside the `.env` file in the root of the `my-exercise` directory.

## Go!

We look forward to seeing your code! 
