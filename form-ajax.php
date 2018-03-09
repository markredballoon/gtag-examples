<?
$form_submitted = false;
$form_error = false;

if ( isset($_POST['work']) ){
    $form_submitted = true;
    if ($_POST['work'] == 'false'){
        $form_error = true;
    }
    if ($_POST['work'] == 'true'){
        $form_error = false;
    }
}

// IF the form was submitted, respond with json
if ($form_submitted && isset($_POST['_form_ajax'])):
    header('Content-Type: application/json');
    $response = array(
        'timestamp' => time(),
        'error' => $form_error
    );
    echo json_encode($response);
else: ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Analytics Example - Forms AJAX</title>
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
        <form id="form" action="./form-ajax.php" method="post">

            <h2>Get in touch</h2>
            <p>Submit the form bellow to send us a message and we'll get back to you as soon as possible.</p>

            <label for="name">Name</label>
            <input type="text" name="name" id="name" <? if($form_submitted && $form_error && isset($_POST['name'])) echo 'value="'.$_POST['name'].'"' ;?>/>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" <? if($form_submitted && $form_error && isset($_POST['email'])) echo 'value="'.$_POST['email'].'"' ;?>/>

            <label for="message">Message</label>
            <textarea name="message" id="message" rows="5"><? 
                if($form_submitted && $form_error && isset($_POST['message'])) echo $_POST['message'];
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
            let errorMessage = document.createElement('p'); // Error message element
                
            /**
             * Clears all form data
             */
            function clearForm(myFormElement) {
                const elements = myFormElement.elements;
                myFormElement.reset();

                for(i=0; i<elements.length; i++) {
                    field_type = elements[i].type.toLowerCase();
                    switch(field_type) {
                        case "text":
                        case "password":
                        case "textarea":
                            elements[i].value = "";
                            break;

                        case "radio":
                        case "checkbox":
                            if (elements[i].checked) {
                                elements[i].checked = false;
                            }
                            break;

                        case "select-one":
                        case "select-multi":
                            elements[i].selectedIndex = -1;
                            break;

                        default:
                            break;
                    }
                }
            }

            // If JS submission is supported
            if (typeof fetch === 'function'){
                const hiddenField = document.createElement('input');
                hiddenField.type = 'hidden';
                hiddenField.name = '_form_ajax';

                FORM.appendChild(errorMessage);
                FORM.appendChild(hiddenField);
            }

            // Focus event
            FORM.addEventListener('focusin', event => {

                if (errorMessage.innerText === 'Thank you for submitting the form'){
                    errorMessage.innerText = '';
                }

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
                // Only use fetch if it is supported
                if (typeof fetch === 'function'){
                    event.preventDefault();

                    const url = FORM.action;
                    const formData = new FormData(FORM);
                    const formParams = new URLSearchParams(formData);
                    
                    fetch(url, {
                        method: 'POST',
                        headers: new Headers({
                            'Accept': 'application/json'
                        }),
                        body: formParams,
                    })
                        .then(resp=>resp.json())
                        .then(json=>{
                            if (json.error == false){
                                // The form was submitted correctly
                                gtag('event', 'form submission', {
                                    'event_category': 'Contact Form',
                                    'event_label': 'submission'
                                });
                                errorMessage.innerText = 'Thank you for submitting the form';
                                clearForm(FORM);

                            } else {
                                // There was an error in the form.
                                gtag('event', 'form error', {
                                    'event_category': 'Contact Form',
                                    'event_label': 'user error'
                                });
                                errorMessage.innerText = 'There was an error with the form data';
                            }
                        })
                        .catch(error=>{
                            gtag('event', 'form error', {
                                'event_category': 'Contact Form',
                                'event_label': 'server response error'
                            });
                            errorMessage.innerText = 'There was an error with the server';
                            throw new Error(error);
                        })
                }
            });

            <? if($form_submitted): ?>
            <? if($form_error): ?>
            // The form was submitted but the information was incorrect
            gtag('event', 'form submission', {
                'event_category': 'Contact Form',
                'event_label': 'user error'
            });
            <? else: ?>
            // The form was submitted correctly
            gtag('event', 'form submission', {
                'event_category': 'Contact Form',
                'event_label': 'submission'
            });
            <? endif; ?>
            <? else: ?>
            // Check if the user has seen the form
            const checkImpression = event => {
                // If the top of the form is above the bottom of the page. 
                // at least 40px must be visible to count as a view
                if (FORM.getBoundingClientRect().top < window.innerHeight - 40){
                    formImpression = true;
                    window.removeEventListener('scroll', checkImpression);
                    gtag('event', 'form impression', {
                        'event_category': 'Contact Form',
                        'event_label': 'viewed contact form',
                        'non_interaction': true
                    });
                }
            }
            checkImpression();
            if (!formImpression){
                window.addEventListener('scroll', checkImpression, {passive: true})
            }
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
</html><? endif; ?>