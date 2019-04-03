# TheSpookyLlamas

Website link: <http://gwupyterhub.seas.gwu.edu/~sp19DBp1-TheSpookyLlamas/TheSpookyLlamas/login.php>


## Database start state
### Required Applicants
  1. John Lennon (complete application)\
    - uid: 55555555\
    - username: john_lennon\
    - password: plsletmein
    
  2. Ringo Starr (incomplete application)\
    - uid: 66666666\
    - username: rstarr\
    - password: Apply!
    
### Other Users
  1. Systems Administrator\
    - uid: 12345678\
    - username: julia320\
    - password: admin1
  2. Grad Secretary\
    - uid: 13254761\
    - username: jacksloane\
    - password: password
  3. Chair of Admissions Committte\
    - uid: 42142172\
    - username: jsmith\
    - password: 123456
  4. Faculty Reviewer\
    - uid: 21147362\
    - username: bn\
    - password: password
    

## Task Distribution
#### Julia
  * created login page
  * created home page and gave each user a different view
  * made all the functionality for the GS, including allowing them to mark documents as received, view existing reviews, and update the final decision
  * did the backend work to ensure that only the forms/info for the selected student was shown
  * made the reset button
  
#### Jack
  * made the application and review forms, complete with validation
  * made a view_application page for the student to view their application before a decision is made
  * made view_review pages so that certain users with access can view the reviews that have been made
  * made the reason_for_reject page which only comes up if the reviewer chooses to reject a student
  * made the Systems Admin home page
  
#### Collaborative
  * created and adjusted apps_schema source file
  * in depth testing, critiquing, and debugging of eachothers work
