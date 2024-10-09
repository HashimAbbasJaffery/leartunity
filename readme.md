# Getting started

At the very first step clone the project.

after cloning the project you will have to install the dependencies which are used by this application. make sure you have composer, and node installed. then run the following command

```composer install```
```npm install```

After installing composer clear cache and config file. and create a key for laravel application. Run following commands in order to proceed:

```php artisan cache:clear```
```php artisan config:clear```
```php artisan key:generate```

Create database, and add credentials in the .env file, after that run the following command

```php artisan migrate```

Lastly, Run these two commands:

```php artisan serve```
```npm run dev```

## Leartunity 0.2.0 Overview

My main aim while developing this application was to create a system in such a way that education feels interesting. we have put multiple gamification things like awarding badges, Streak system.

## Functionalities

- Adding Courses
- Awarding certificates to the learner
- Localization
- Multi-currency
- Give review to specific course
- Wallet system
- Profile Management
- Follow multiple users
- Streak system
- Efficient course filtration
  
#### For instructors

- Adding courses
- Add Quizzes
- Recieve earnings
- Markdown Support while writing description in each course

#### For Admins

- Display Few Analytics
- Bannable users
- Manage Categories
- Change website main colors, and fonts by clicking

### What's New in this version...

In this version I have introducts two things.

- This entire project is now based on SPA, which was created using VUEJS framework in Laravel.
- Secondly, Now when user create/updates content pleasing I introduced pleasing progress system. that does not confuse users about the progress of uploading content.
  
I removed few things in this version.

- Referral System (It will be introduced again)
- Multi-language system

### Future Update Logs

- Instructor will be able to start live sessions in this web application. and every follower will recieve the notification about this live session.
- Right now instuctors are static, in very upcoming days user will apply to become the instructur. and that user will be passed through multiple stages to ensure the high quality courses. 


NOTE: THERE MIGHT BE SOME BUGS, WHICH WILL BE RESOLVED IN UPCOMING DAYS. IF YOU FOUND ANY BUG MAKE SURE TO REPORT AT THIS EMAIL habbas21219@gmail.com.

YOU NEED TO HAVE FFMPEG IN YOUR MACHINE IN ORDER TO RUN THIS PROJECT!