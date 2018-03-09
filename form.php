<?
$form_submitted = false;
$form_error = false;

if ( isset($_GET['work']) ){
    $form_submitted = true;
    if ($_GET['work'] == 'false'){
        $form_error = true;
    }
    if ($_GET['work'] == 'true'){
        $form_error = false;
    }
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Analytics Example - Forms</title>
    <link rel="stylesheet" href="default.css">

    <script>
        // Replace this with the tracking code
        gtag = function(){
            console.log(arguments);
        }

        // Set gtag to use beacon method
        gtag('config', 'GA_TRACKING_ID', { 'transport_type': 'beacon'});
    </script>

    <style>
        .wrap{
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f6f6f6;
        }
        #form{
            background: #fff;
            margin: auto;
            width: 420px;
            padding: 20px;
            max-width: 100%;
            display: grid;
            grid-column-gap: .6rem;
            grid-row-gap: 1rem;
            grid-template-columns: 80px 1fr;
        }
        #form input[type="submit"], 
        #form h2, 
        #form p,
        #form fieldset{
            grid-column-start: 1;
            grid-column-end: 3;
        }
        #form fieldset{
            text-align: center;
        }
        #form fieldset label{
            display: block;
        }
        h2{
            margin:0;
            text-transform: uppercase;
            text-align: center;
        }
        #form p{
            margin: 0;
            text-align: center;
        }
        textarea{
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <form id="form" action="./form.php" method="get">

            <h2>Get in contact</h2>
            <p>Submit the form bellow to send us a message and we'll get back to you as soon as possible.</p>

            <label for="name">Name</label>
            <input type="text" name="name" id="name" <? if($form_submitted && $form_error && isset($_GET['name'])) echo 'value="'.$_GET['name'].'"' ;?>/>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" <? if($form_submitted && $form_error && isset($_GET['email'])) echo 'value="'.$_GET['email'].'"' ;?>/>

            <label for="message">Message</label>
            <textarea name="message" id="message" rows="5"><? 
                if($form_submitted && $form_error && isset($_GET['message'])) echo $_GET['message'];
            ?></textarea>

            <fieldset>
                <legend>Form submitted correctly</legend>
                <label for="work_true">
                    True
                    <input type="radio" name="work" id="work_true" value="true" required />
                </label>
                <label for="work_false">
                    False
                    <input type="radio" name="work" id="work_false" value="false" required />
                </label>
            </fieldset>

            <input type="submit" vale="Submit" />

            <? if($form_submitted): ?>
                <? if($form_error): ?>
                <p>The form was submitted incorrectly</p>
                <? else: ?>
                <p>The form was submitted correctly</p>
                <? endif; ?>
            <? endif; ?>

        </form>
    </div>

    <script>
        // Immediatly envocing function to preserve global namespace
        (function(){

            // Set variables
            const FORM = document.getElementById('form'); // The form
            const formProgress = {}; // Tracks what has been filled out in the form
            let formSubmit = false; // If the form is submitted
            let formLabel = ''; // Label to send in event, built from the different forms
            let formImpression = false; // Track if the user has seen the form

            // Focus event
            FORM.addEventListener('focusin', event => {
                // Check element type
                const validElements = ['INPUT', 'TEXTAREA'];
                if (!validElements.includes(event.target.nodeName)){
                    return;
                }
                
                // Check input type is correct
                const invalidTypes = ['checkbox', 'radio', 'submit'];
                if ( event.target.nodeName === 'INPUT' && invalidTypes.includes(event.target.type) ){
                    return;
                }
                
                // Update progress
                // If the field hasn't been filled out add it to the label and then set the progress to true
                if (!formProgress[event.target.name]){
                    formLabel += event.target.name + ' > ';
                    formProgress[event.target.name] = true;
                }
            });

            // Form submit event
            FORM.addEventListener('submit', event => {
                // This will prevent a 'form abandonment' event from firing
                formSubmit = true; 
            });


            <? if($form_submitted): ?>
            <? if($form_error): ?>
            // The form was submitted but the information was incorrect
            gtag('event', 'form submission', {
                'event_category': 'Contact Form',
                'event_label': 'error'
            });
            <? else: ?>
            // The form was submitted correctly
            gtag('event', 'form submission', {
                'event_category': 'Contact Form',
                'event_label': 'submission'
            });
            <? endif; ?>
            <? else: // Only track impressions on users who haven't already tried to submit the form. ?>
            // Check if the user has seen the form
            const checkImpression = event => {
                // If the top of the form is above the bottom of the page. 
                // at least 40px must be visible to count as a view
                if (FORM.getBoundingClientRect().top < window.innerHeight - 40){
                    window.removeEventListener('scroll', checkImpression);
                    formImpression = true;
                    gtag('event', 'form impression', {
                        'event_category': 'Contact Form',
                        'event_label': 'viewed contact form',
                        'non_interaction': true
                    });
                }
            }
            window.addEventListener('scroll', checkImpression, {passive: true})
            checkImpression();
            <? endif; ?>

            // Add event listener for the unload event
            window.addEventListener('beforeunload', event => {
                // If the form hasn't been submitted but was interacted with
                if (!formSubmit && formLabel.length > 0){

                    // Trim the trailing ' > '
                    formLabel = formLabel.slice(0, -3);

                    // Fire the event
                    gtag('event', 'form abandonment', {
                        'event_category': 'Contact Form',
                        'event_label': formLabel
                    })
                }
            });
        })();
    </script>

</body>
</html>