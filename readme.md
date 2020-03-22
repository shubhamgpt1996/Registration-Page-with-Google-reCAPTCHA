# Registration-Page-with-Google-reCAPTCHA
This project has a very basic registration page along with a Google reCAPTCHA if there are more than 3 users trying to register from the same IP. This will help you from spamming and fake users.




Instructions for this Project:
	->    Clone this project
	->    Run command: cp .prod.env .env
	->    Configure the below mentioned fields as per your config
			MONGODB_DATABASE	-	database name
			MONGODB_USERNAME	-	ignore if no authentication is there
			MONGODB_PASSWORD	-	ignore if no authentication is there
			MONGODB_PORT	-	ignore if default port is being used
			MONGODB_HOST	-	ignore if localhost is being used
			MONGODB_AUTH	-	ignore if no authentication is there
			USER_COLLECTION	-	collection name
			RECAPTCHA_SECRET_KEY	-	secret key provided while signing up for the google recaptcha
			RECAPTCHA_SITE_KEY	-	site key provided while signing up for the google recaptcha
	->    Run this command to start the server
			php artisan serve
	->    Navigate to - http://localhost:8000
