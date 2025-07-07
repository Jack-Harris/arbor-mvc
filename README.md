
# Overview of Solution

I decided to create a minimal custom MVC framework from scratch for this project.

`app` contains the models, views, controllers, migrations and services.

`framework-core` contains the custom framework logic. Mostly the base classes, e.g. Model, Controller.

`public` contains the PHP entrypoint.

The logic to import the data is at `app/services/JSONImporter.php`.

The database schema definition is in the migration in `app/migrations/`.

# How to run

You will need to have docker and docker compose.

- Run `docker compose up --build`. This should install all dependencies, run the migration to create the database schema and import the data.
- The application will run at `localhost:8080`.

# Entity Relationship Diagram

![arbor-erd drawio (1)](https://github.com/user-attachments/assets/6df658f2-c8cb-4289-956d-418ffb84e350)


# Where I focused most of my effort

The development of the actual framework ended up being the biggest technical challenge. Due to this, I wasn't able to spend as much time on other parts of the project such as UX, testing and breaking down the data in a more useful way.

If you'd like to see examples of other projects that I've done which demonstrate skills in these areas, please see https://jack-harris.com

# Notes

- In normal circumstances, I would never commit the .env file. However in this case, there is no actual sensitive information and so I have done so in order to simplify sharing the project.
- If I had more time, I would have written tests for this project but I deemed this to be out of scope due to the time limitations, even though in hindsight, I should have prioritised this more.

# Assumptions

- Every school has a webhook, and only one webhook - therefore the webhook URL is a valid unique identifier of a school.
- A student will only have one guardian.
- Every student only belongs to one school.
- Read rate refers to the ratio between delivered to total sent messages excluding messages which failed to send.
