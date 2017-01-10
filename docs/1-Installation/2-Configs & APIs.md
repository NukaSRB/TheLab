# Configs & APIs

- [Configs](#configs)
    - [.env](#configs-env)
- [APIs](#apis)
    - [Google](#apis-google)
        - [Create your project](#apis-google-project)
        - [Add OAuth consent](#apis-google-consent)
        - [Get OAuth Client credentials](#apis-google-credentials)
        - [Enable the necessary APIs](#apis-google-library)
    - [Toggl](#apis-toggl)
    - [Asana](#apis-asana)

<a name="configs"></a>
## Configs
<a name="configs-env"></a>
### .env
Copy the `.env.example` file to a file called `.env`.  Update this file with your local details.  The important ones are:

1. DB_*
1. GOOGLE_*
1. TOGGL_*
1. ASANA_*

<a name="apis"></a>
## APIs
<a name="apis-google"></a>
### Google
1. Make sure you are logged into chrome/google as your work account.
1. Go to [Google API Console](https://console.developers.google.com/apis/).

<a name="apis-google-project"></a>
#### Create your project
1. At the top click the drop down and select `Create Project`.  
    - Name it whatever you like.
1. Select your new project from the drop down list.
    
<a name="apis-google-consent"></a>
#### Add Oauth consent
1. Click `Credentials`.
1. Click `OAuth Consent Screen` (Tab).
    - Make sure your email is your work email.
    - Set the product name.
    
<a name="apis-google-credentials"></a>
#### Get OAuth Client credentials
1. Click `Credentials`.
1. Click `Create Credentials`.
1. Select `Oauth Client ID`.
1. Select `Web Application`.
1. The name can be anything you want.
1. No `Authorized JavaScript origins`.
1. Set the `Authorized redirect URIs` to `http://your-domain.dev/callback/google`.
    - Make sure this matches your local set up as <your site>/callback/google.
1. Click `Create`
    
<a name="apis-google-library"></a>
#### Enable the necessary APIs
In the `Library` page, you can enable the APIs you need access to.  Click on each of the APIs listed below, then click 
the enable button.

- Google+ API
- Drive API
- Calendar API
        
<a name="apis-toggl"></a>
### Toggl
You will want to get an admin toggl key.  Ask David for this.

<a name="apis-asana"></a>
### Asana
In progress...

<a name="apis-gitlab"></a>
### GitLab

1. Go to your profile in [GitLab](http://gitlab.siterocket.com)
1. Select applications
1. Create a new application
1. Use the Application ID, Secret and redirect URI and add them to your `.env`.
    - The redirect URI should be <your-domain>/link/callback/gitlab
