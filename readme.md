#  Welcome to Laravel Hotel Booking

> First set your database name, username and password in .env file
> Do composer update.
> run php artisan migrate command to create necessary tables in your database.
> run npm install commnd to install dependent package

Repository URL: https://gitlab.com/arsenaltech/hotel-booking-crud


# Project configuration
- Clone the repository url into the desired folder
- Setup the database credentials in the ".env" file in your project root folder.

# Backend API implementation with laravel
- There is single controller in the application, with all the methods defined in here have their specific tasks. No methods is serving their own task without mixing or interfering into other's tasks.
- All the data fetched or stored from controller is in the json format, so our API component is able to work.
- We have implemented the repository pattern for our model to fetch and store all the data.
- Additionally, I have created CachedHotelRepository to add the caching support which utilizes decorator pattern. Any supported caching methodology like redis, memcache can be implemented with this pattern not touching all the parts of the code. This repository is using the same interface as that of main repository as their method-names but the main repository interacts with the database while this repository is meant to deal with the Cached data without talking to database.
- For making system more scalable: I have implemented paging as well.
- All the controller methods return the json responses so these are re-usable APIs and also server the controller purpose.

# Front end implementation with Vue Components
- I have used vue js for the front end development as Vue comes out of the box with Laravel. I can implement same with React considering it's not much different.
- There are three main components used in the vue part. - Hotellist, Add/Edit HotelForm and notification.
app.js is the main config file, which has the configuration for the application modules and components.
- For routing purpose, I have used vueRouter component,which allows to bind the form controls with the specific routes
- For communicating with the laravel API, I am using axios component, which will work and perform server side commands to either fetch or store the data.
- I am using custom Form class to take care of basic form processing and error handling
- Regarding unit tests, I would have surely created that if there were other modules or if there was any complex task, but in this case writing unit tests will not be much helpful.