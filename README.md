# TextToDo

This repository contains our final project for Web Application Development. 
By Jason Morse, Nicolas Chahin, and Edward Lee. 
See wiki for more information. 

4/3 (from Canvas)
use case needs work, idea okay

4/11 - Project proposal
- You could add location based information to the reminders.
- You could also have recurring reminders (i.e. a text sent out for a weekly meeting).
- Followup, or ack?  I'm thinking some kind of feedback to show what is effective.  Can
you reply to an sms>
- Any reporting?  Admin could find info quantity of reminders by user, by date, by
day of the week...

please put all documentation in the docs folder

=======
4/23 - Data documentation
RUBRIC - For Data Documentation
CRITERIA:
Create SQL Complete for all tables. Table names and field names well
chosen, clearly presented.
COMMENTS:
Yup
SCORE: 5 / 5 pts 
**********************
CRITERIA:
Populate SQL Complete - data is representative. All associations have
specific records demonstrating their relationships.
COMMENTS:
Everything is there.  All creates, and populates.
SCORE: 5 / 5 pts 
**********************
CRITERIA:
All use cases documented with actor, pre/post conditions, queried and UI
mockup - there must be a sufficient number of use cases to receive full
credit. Five is the absolute minumum. Is the purpose and function of the
use case clear?
COMMENTS:
- It bothers me that you delete items when complete.  I always like to see 
a list of what I have completed.
- Use Case 3 - When adding friends to a list, you will need a select query to populate 
your friends list.
- What is dumbkey in use cases?  You need selects to find the tasks/lists etc 
to update/delete
- Nail down admin reporting very soon.
SCORE: 30 / 30 pts 
**********************
CRITERIA:
Is purpose and function of the project clear? Note this is only 5
points, but its really crucial.
COMMENTS:
Yes
SCORE: 5 / 5 pts 
**********************
CRITERIA:
Data documentation includes a ER diagram.
COMMENTS:
Yes - looks good
SCORE: 5 / 5 pts 
**********************
Total Points: 50 out of 50

**********************

5/8 - Final Comments
- Feel free to register a new account or use existing ones to see create/see sample data (username: morsejm, password: jason; username: leebkv, password: edward)
- SMS alerts are sent out whenever a user adds a new item to a list (goes to all subscribers except the person who created the task) and whenever a user checks off a task and chooses to "force remind" subscribers by clicking the button
- The Twilio trial account restricts us from sending messages to unverified numbers, so if you'd like to test it out yourself, we'll need to manually add your number to the "verified" list in our Twilio account
