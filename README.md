
# Overview of solution

I decided to create a minimal MVC framework from scratch for this project.

# How to run

You will need to have docker and docker compose.

@todo

# Entity Relationship Diagram



# Where I focused most of my effort

The development of the actual framework ended up being the biggest technical challenge. Due to this, I wasn't able to spend as much time on other parts of the project such as UX, testing and breaking down the data in a more useful way.

If you'd like to see examples of other projects that I've done which demonstrate skills in these areas, please see https://jack-harris.com

# Notes

- In normal circumstances, I would never commit the .env file. However in this case, there is no actual sensitive information and in order to simplify sharing the project.
- If I had more time, I would have written tests for this project but I deemed this to be out of scope due to the time limitations, even though in hindsight, I should have prioritised this more.


# Assumptions

- Every school has a webhook, and only one webhook - therefore the webhook URL is a valid identifier.
- A student will only have one guardian.
- Every student only belongs to one school.
- Read rate refers to the ratio between delivered to total sent messages.