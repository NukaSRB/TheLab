# Configs & APIs

## .env
Copy the `.env.example` file to a file called `.env`.  Update this file with your local details.  The important ones are:

1. DB_*
1. GOOGLE_*
1. TOGGL_*
1. ASANA_*

## APIs
### Google
1. Make sure you are logged into chrome/google as your work account.
1. Go to [Google API Console](https://console.developers.google.com/apis/).
1. At the top click the drop down and select `Create Project`.  
    1. Name it whatever you like.
    1. Select your new project from the drop down list.
1. Click `Credentials`.
1. Click `OAuth Consent Screen` (Tab).
    1. Make sure your email is your work email.
    1. Set the product name.
1. Click `Credentials` (Tab).
1. Click `Create Credentials`.
    1. Select `Oauth Client ID`.
    1. Select `Web Application`.
    1. The name can be anything you want.
    1. No `Authorized JavaScript origins`.
    1. Set the `Authorized redirect URIs` to `http://your-domain.dev/callback/google`.
        * Make sure this matches your local set up as <your site>/callback/google.
    1. Click `Create`
1. Click `Library`
    1. Click `Google+ API`
        1. Click `Enable`
    1. Click `Drive API`
        1. Click `Enable`
    1. Click `Calendar API`
        1. Click `Enable`
        
### Toggl
You will want to get an admin toggl key.  Ask David for this.

### Asana
In progress...
