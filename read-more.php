<?php
// BOOTSTRAPPING
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Post {
    public $ID;
    public $post_title;
    public $post_excerpt;
    public $post_content;
    function __construct(){
        $this->ID = '';
        $this->post_title = 'homepage quote';
        $this->post_excerpt = 'Lorem ipsum dolor sit amet.';
        $this->post_content = 'Curabitur eu convallis purus, non posuere lectus. Donec venenatis ex sit amet mauris gravida tempus. Etiam laoreet non velit vitae auctor. Suspendisse at nulla id dui pharetra malesuada. Donec ut urna nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.';
    }
}
function apply_filters($text){
    return "<p>$text</p>";
};
function get_post_meta($name = '', $post = 0){
    return 'Tom';
}
$n = 0;
$quote = new Post();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Analytics Example - Read More</title>
    <link rel="stylesheet" href="default.css">
    <style>
        .quote{
            margin: 2rem auto;
            width: 400px;
            max-width: 100%;
            padding: 10px;
        }
        .quote-full{
            display: none;
        }
        .quote-open .quote-full{
            display: block;
        }
        .quote blockquote{
            margin: 1rem 0;
        }
    </style>
    <script>
        gtag = function(){
            console.log(arguments);
        }
    </script>
</head>
<body>
<?php
// END: BOOTSTRAPPING
?>
    <div class="quote" id="quote-<?= $n; ?>" data-quote-id="<?= $quote->ID; ?>" data-quote-title="<?= $quote->post_title; ?>">
        <div class="quote-background">
            <div class="quote-text">
                <blockquote>
                    <div class="quote-highlight"><p><?= $quote->post_excerpt; ?></p>
                </div>
                <div class="quote-full">
                    <?= apply_filters($quote->post_content); ?>
                </div>
                <cite><?= get_post_meta('_quote_citation', true); ?></cite>
            </blockquote>
        </div>
        <div class="quote-read-more">
            <button class="quote-read-more-button" data-target="#quote-<?= $n; ?>">read more</button>
        </div>
    </div>

    <script>
        // Get all the read more buttons from the page
        const readMoreButtons = Array.from(document.querySelectorAll('.quote-read-more-button'));

        // Loop through the read more buttons
        readMoreButtons.forEach((element, index, array) => {

            // Add an event listener for each of the buttons
            element.addEventListener('click', (event)=>{
                // Check that the target exists
                if (!element.dataset.target) return;
                const target = document.querySelector(element.dataset.target);
                if (target === null) return;

                // If the quote is open then close it
                if (target.classList.contains('quote-open')){
                    target.classList.remove('quote-open');
                    return
                }

                // Otherwise open the quote
                target.classList.add('quote-open');

                // Send an event to google analytics
                const eventLabel = target.dataset.quoteTitle !== undefined ? 
                    `opened quote ${target.dataset.quoteTitle}` : 'opened quote';

                const eventValue = parseInt(target.dataset.quoteId) || 0;
                
                gtag('event', 'read-more', {
                    'event_category': 'Quotes',
                    'event_label': eventLabel,
                    'value': eventValue
                });

            });
        });
    </script>
</body>
</html>