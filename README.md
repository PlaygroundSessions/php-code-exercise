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
