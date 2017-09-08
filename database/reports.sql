/*
    AppAdmin should be able to able to customize the reports using the following:
    REGISTRATION REPORT 
*/

/* Total number of Users on the App */
SELECT * FROM `users` WHERE `user_type` != 4;

 /* Total number of Users using English(1) and Arabic(2) */
SELECT * FROM `users` WHERE `language` = 1;

 /* Total number of Users as Regular Benefit(1) or Benefit Plus(2) */
SELECT * FROM `users` WHERE `user_type` = 1;

 /* Total number of Users upgrading to Benefit Plus */


 /* For BENEFIT PLUS - number of users as Insurance Users(2) vs Corporate users(1) vs Private users(3) breakdown */
 SELECT * FROM `users` WHERE `activation_type` = 1; 

 /* Gender breakdown of Users (Male(1) / Female(2) */
SELECT * FROM `users` WHERE `gender` = 1;

 /* Age breakdown (20-25 / 25-30 / 30-35 / 35-40 / 40-45 / 45-50 / 50-60 / 60+) */
SELECT * FROM `users` WHERE (DATEDIFF(CURDATE(),dob) / 365.25) BETWEEN 20 AND 25;

 /* Users per Emirate (Dubai, Abu Dhabi, Al Ain, Sharjah, Ajman, Ras Al Khaima, Fujairah) */
SELECT * FROM `users` WHERE `city` LIKE 'Abu Dhabi' ORDER BY `address` ASC

 /* Number of Users on the basis of Nationality breakdown */
SELECT * FROM `users` WHERE `nationality` LIKE 'india';

 /* Exercise User breakdown  on the basis of 1,2,3,4,5 per week */
SELECT exercise_hour_per_week,users.* FROM user_wellness_answers join users on user_wellness_answers.user_id = users.user_id 
WHERE user_wellness_answer_id IN (SELECT MAX(user_wellness_answer_id) FROM user_wellness_answers GROUP BY user_id) 
AND exercise_hour_per_week = 1;

 /* Nutrition User breakdown  on the basis of Poor, Average, Good, Very Good) eating_habit:(Very Poor = 1, Poor = 2,  Average =3, Good =4, Excellent =5) */
SELECT eating_habit,users.* FROM user_wellness_answers join users on user_wellness_answers.user_id = users.user_id 
WHERE user_wellness_answer_id IN (SELECT MAX(user_wellness_answer_id) FROM user_wellness_answers GROUP BY user_id) 
AND eating_habit = 2;

 /* Number of smokers on the basis of gender, age, nationality */
SELECT count(*) FROM user_wellness_answers join users on user_wellness_answers.user_id = users.user_id 
WHERE user_wellness_answer_id IN (SELECT MAX(user_wellness_answer_id) FROM user_wellness_answers GROUP BY user_id) AND cigrattes_per_day > 0 
AND users.gender = 2;

SELECT count(*) FROM user_wellness_answers join users on user_wellness_answers.user_id = users.user_id 
WHERE user_wellness_answer_id IN (SELECT MAX(user_wellness_answer_id) FROM user_wellness_answers GROUP BY user_id) AND cigrattes_per_day > 0 
AND users.gender = 2 AND (DATEDIFF(CURDATE(),users.dob) / 365.25) BETWEEN 20 AND 30;

SELECT count(*) FROM user_wellness_answers join users on user_wellness_answers.user_id = users.user_id 
WHERE user_wellness_answer_id IN (SELECT MAX(user_wellness_answer_id) FROM user_wellness_answers GROUP BY user_id) 
AND cigrattes_per_day > 0 AND users.gender = 2 AND (DATEDIFF(CURDATE(),users.dob) / 365.25) BETWEEN 20 AND 30 AND nationality = 'Indian';

 /* Number of alcoholist on the basis of gender, age, nationality */
 /* We are not capturing alcoholist in the App */

 /* Number of Diabetics  on the basis of gender, age, nationality Diabetes:(Yes = 1, No = 2, Don’t Know = 3)*/
SELECT count(*) FROM user_wellness_answers join users on user_wellness_answers.user_id = users.user_id 
WHERE user_wellness_answer_id IN (SELECT MAX(user_wellness_answer_id) FROM user_wellness_answers GROUP BY user_id) 
AND users.gender = 2 AND diabetes = 1;

SELECT count(*) FROM user_wellness_answers join users on user_wellness_answers.user_id = users.user_id 
WHERE user_wellness_answer_id IN (SELECT MAX(user_wellness_answer_id) FROM user_wellness_answers GROUP BY user_id) 
AND users.gender = 2 AND (DATEDIFF(CURDATE(),users.dob) / 365.25) BETWEEN 20 AND 30 AND diabetes = 1;

SELECT count(*) FROM user_wellness_answers join users on user_wellness_answers.user_id = users.user_id 
WHERE user_wellness_answer_id IN (SELECT MAX(user_wellness_answer_id) FROM user_wellness_answers GROUP BY user_id) 
AND users.gender = 2 AND (DATEDIFF(CURDATE(),users.dob) / 365.25) BETWEEN 20 AND 30 AND nationality = 'Indian' AND diabetes = 1;

 /* User's Name, Email Address/Activation Code and Contact Number, if provided */
 /* Covered In first Query */


/* ACTIVITY REPORTS */
/* User's Name, Email Address/Activation Code and Contact Number, if provided */
/* Most active users (Nationality comparison and eg. UAE National vs Expatriate on the basis of month / year */
/*  Users per status  (gender, age, nationality) */
/*  Users achevied weekly goals */
/*  Users achieved status upgrades */
/*  Number of members using fitness device (gender, age, nationality) */
/*  Gym visits report (month, year / gender, age, nationality) */
/*  Users interested in BENEFIT PLUS  ""Im Interested"" (gender, age, nationality, emirate) */
/*  Users interested in HEALTHY MEAL PLANS ""Im Interested"" (gender, age, nationality, emirate, partner) */
/*  Number of members accessed HEALTH INSURANCE ""Im Interested"" (gender, age, nationality, emirate, partner) */
/*  Number of users accessing Experts */
/*  Total number of Expert bookings (Month, Year) */
/*  Number of professionals registered to booking platform (Personal Trainers, Physios, Chiropractors, Nutritionists, Homepaths, Diabetes Professionals) */
/*  Total number of times Benefit App has been downloaded */

/* REWARD REPORTS */
/* Total points earned (monthly) */
SELECT sum(points) as total_points_earned,month(user_points_history.created_at) as earned_point_month,year(user_points_history.created_at) 
as earned_point_year,users.* FROM `user_points_history` join users on user_points_history.user_id = users.user_id WHERE type = 1 
GROUP BY EXTRACT(YEAR_MONTH FROM user_points_history.created_at);

/* Total points spend (monthly) */
SELECT sum(points) as total_points_spend,month(user_points_history.created_at) as spend_point_month,year(user_points_history.created_at) 
as spend_point_year,users.* FROM `user_points_history` join users on user_points_history.user_id = users.user_id WHERE type = 2
GROUP BY EXTRACT(YEAR_MONTH FROM user_points_history.created_at);

/* Average points earned (weekly, monthly) */
/* Average points spend (monthly) */
/* Number of members accessing REWARDS */ 
/* Number of members accessing AUTOMATIC BENEFITS */

