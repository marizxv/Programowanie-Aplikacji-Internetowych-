# *Plant Care Diary — application/project description*

The application is a personal plant care tracker. The core idea is simple: a user registers,
adds their houseplants to their account, and keeps a diary of every time they water, fertilise,
or repot them. Instead of trying to remember when you last watered your monstera (a succulent, in my case), 
one can open the app and it'd tell them everything.

## User's perspective

A guest visiting the site can browse a public catalogue of plant types (succulents, tropical plants,
herbs, etc. – hopes ad prayers I find an actual database )and see general care information 
— but they can't do anything personal until they register.

Once logged in, a user can add their own plants to their account, giving each one a name 
(e.g. "my big monstera by the window") and linking it to a plant type from the catalogue. 
Every time they water or fertilise a plant, they add a care log entry — a short note with a timestamp. 
Over time this builds up a history: "I watered this plant on the 1st, 8th, and 15th — looks like I'm doing
it every 7 days." 

~~Fully depends on one's pattern recognition, now that I think of it.~~

*! Search and filtering*

Users can search and filter in two places. First, in the plant catalogue — filtering by type
(only show succulents), or searching by name. Second, in their own plant list and care history, such as 
filtering care logs by date range ("my divine Self wishes to unseal the divine scrolls dated March") 
or by action type ("show me only watering entries, *for I am no peasant and posses treasurable dihydrogen 
monoxide!*"). This is especially useful once someone has 10+ plants with dozens of log entries and way 
too little space for more mental load.

## The admin's role

The admin *never* interacts with anyone's plants. Their job is purely system management
— they maintain the plant types catalogue (adding new types like "cactus" or "bonsai",
deactivating outdated ones), and they manage user accounts (resetting passwords, assigning roles,
removing accounts if needed).

**The roles in short:**
- **Guest** — browses the public plant catalogue, registers or logs in;
- **User** — manages their own plants and care diary;
- **Admin** — manages plant types (database) and user accounts. Doesn't even touch the creation of one's
personal diary enties. ~~Want an own plant? Too bad.~~


  
*So I don't forget:* 

| Action | Guest | User | Admin |
|---|---|---|---|
| Browse public plant catalogue | O | O | O |
| Register | O | X | X |
| Add own plants | X | O | X |
| Log watering / care entries | X | O | X |
| View own plant diary | X | O | X |
| Manage plant types (catalogue) | X | X | O |
| Manage users & roles | X | X | O |
| Search & filter everything | O | O | O |


**TODO: add the description of the technical side once done with it (or is it supposed to be in a separate file?
Guess I'll find out later.)** 
