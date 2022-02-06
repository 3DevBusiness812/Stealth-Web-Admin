@component('mail::message')


Hi {{ $fullName }},

<br>
Welcome to Stealth Premium - your full access pass to the complete library of Stealth Premium Games.
<br>
You will also receive a new Stealth Game at the end of every month, as well as complete access to the Premium Games that are already released.
<br>
Here's what you need to do next to activate your account:
<br>
<br>
1. Download the Stealth Body Fitness App to your phone from the App Store or Google Play Store.
<br>
You can use the direct links below or search “Stealth Body Fitness” in the App Store or Google Play Store.
<br>
iPhone Users Tap Here: <a href="https://apps.apple.com/us/app/stealth-body-fitness/id1360949647" > https://apps.apple.com/us/app/stealth-body-fitness/id1360949647 </a>
<br>
Android Users Tap Here: <a href="https://play.google.com/store/apps/details?id=com.stealth.stealthcorechallenge2&hi=en_US" > https://play.google.com/store/apps/details?id=com.stealth.stealthcorechallenge2&hi=en_US </a>
<br>
<br>
2. Login to your Stealth Premium account using the following credentials:
<br>
<b>
Email : {{ $username }}
@if($password != '')
<br>
Password: {{ $password }}
</b>
<br> 
On your first login, you will be prompted to change this default password.
@else

<br>
@endif
<br>
4. That’s it! After you login, tap “Stealth Games & Workouts” to view all of the premium games you have access to.
<br> 

<b>Game Your Core and Have Fun!</b>

<br>
If you have any issues, please email support@gameyourcore.com with a short description.
<br>
Please include your phone model and mention that you are a premium subscriber. 

<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
