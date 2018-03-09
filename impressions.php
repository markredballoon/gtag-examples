<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Analytics Example - Impressions</title>
    <link rel="stylesheet" href="default.css">
    <style>
        .wrap{
            max-width: 100%;
            display: grid;
            grid-gap: 10px;
            grid-template-areas: 'header header header' '. article .' 'footer footer footer';
            grid-template-columns: 1fr 930px 1fr;
            grid-template-rows: 40px auto 40px;
        }
        .site-header{
            grid-area: header;
            background: #444;
        }
        .site-footer{
            grid-area: footer;
            background: #444;
        }

        .page-article{
            grid-area: article;
            display: grid;
            grid-gap: 10px;
            grid-template-areas: 'header sidebar' 'main sidebar' 'footer footer';
            grid-template-columns: 1fr 300px;
            grid-template-rows: auto auto minmax(50px, max-content);
            grid-auto-columns: auto;
            grid-auto-rows: auto;
        }
        .article-header{
            grid-area: header;
        }
        .article-footer{
            grid-area: footer;
            background: #999;
        }
        .page-article main{
            grid-area: main;
        }
        .page-article aside{
            grid-area: sidebar;
            background: #bbb;
        }

        figure{
            margin: 0 0 1rem .5rem;
            float: right;
            max-width: 50%;
        }
        img{
            height: auto;
            max-width: 100%;
            display: block;
        }
        figcaption{
            font-style: italic;
            font-size: .8rem;
        }

        @media screen and (max-width: 950px){
            .wrap{
                grid-template-columns: 10px 1fr 10px;
            }
        }
        @media screen and (max-width: 780px){
            .page-article{
                display: grid;
                grid-gap: 6px;
                grid-template-areas: 'header' 'main' 'sidebar' 'footer';
                grid-template-columns: 1fr;
                grid-template-rows: auto auto minmax(300px, max-content) minmax(50px, max-content);
                grid-auto-columns: auto;
                grid-auto-rows: auto;
            }
        }
    </style>
    <script>
        gtag = function(){
            console.log(arguments);
        }
    </script>
</head>
<body>
    <div class="wrap">

        <header class="site-header"></header>

        <article class="page-article">
            <header class="article-header">
                <h1>Article Title goes here</h1>
            </header>
            <main>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur nunc tortor, feugiat vitae facilisis non, ullamcorper et lacus. Mauris porttitor tempus lorem, non aliquet velit tristique ut. Suspendisse vitae quam accumsan, lacinia ipsum id, porta sem. Etiam sit amet erat et sem scelerisque maximus. Donec eget mattis enim. Cras nec aliquam lectus, posuere consequat risus. Aliquam accumsan, velit id molestie interdum, erat est commodo tellus, sit amet tincidunt lectus mauris sit amet sapien. Curabitur eu dui non tellus sagittis pellentesque vel in neque. Integer laoreet in odio id aliquet. Quisque fermentum sed sapien sed congue. Nam in massa ac tortor fringilla sodales at nec dui. Nulla condimentum at odio nec feugiat. Nullam et fermentum turpis. Maecenas facilisis iaculis turpis. Vestibulum quis fringilla tellus, et eleifend tortor. Pellentesque vel mi quis purus vehicula mattis.</p>
                <p>Aliquam eros quam, porttitor ac ullamcorper et, volutpat sed ex. Nam tincidunt metus sapien, nec ultricies tellus condimentum eu. Curabitur rutrum orci ex, vel molestie purus cursus sit amet. Vivamus convallis magna id viverra pretium. Fusce at facilisis metus. Aliquam eget augue libero. Cras a elit fringilla, facilisis tortor ut, fermentum erat. Phasellus vel eros enim. Mauris leo dolor, pellentesque mattis est sed, semper viverra est.</p>
                <figure>
                    <img src="http://via.placeholder.com/350x250/330000/f5f5f5" alt="Placeholder image">
                    <figcaption>An image in the document</figcaption>
                </figure>
                <p>Cras ultrices tincidunt venenatis. In hac habitasse platea dictumst. Pellentesque ultricies imperdiet porta. Donec feugiat interdum tellus, et vulputate mauris vulputate a. Nunc tellus ipsum, suscipit sed tellus vel, consequat dignissim nibh. In nec porttitor ipsum, non dapibus ex. Nullam sit amet viverra ligula. Cras faucibus dignissim sodales. Morbi in erat scelerisque, auctor nibh sed, luctus nulla. Praesent lacinia nisl at viverra pharetra.</p>
                <p>Pellentesque libero magna, feugiat eget nibh id, convallis sagittis mi. Morbi consequat dolor malesuada libero pulvinar placerat. In efficitur massa velit, et aliquet ligula efficitur in. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pretium leo ac est ornare placerat. Nulla fermentum enim justo, vel sodales dui laoreet sed. Aenean dapibus, sapien ac blandit tincidunt, magna sem consectetur mauris, in aliquet libero mi eget purus. Donec tempus blandit augue ut pulvinar. Integer hendrerit, purus id posuere rutrum, odio tortor elementum tellus, sit amet euismod tortor lorem eget risus. Morbi blandit ut risus a pharetra. Sed dui sem, tristique eleifend diam ut, semper vulputate lorem. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                <p>Integer dictum pellentesque velit, eu sodales elit. Maecenas dignissim nibh in nulla malesuada accumsan. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam dignissim turpis non volutpat pulvinar. Nunc posuere tempus nibh non fermentum. Nulla in sem a arcu varius rutrum vel nec odio. Maecenas at auctor ex. Proin feugiat id velit a efficitur. Ut et consectetur leo, at feugiat purus. Vivamus vitae nisl diam. Nulla facilisi.</p>
            </main>
            <aside>Article Sidebar</aside>
            <footer class="article-footer">
                Article footer
            </footer>
        </article>

        <footer class="site-footer">
            Site footer
        </footer>
    </div>

    <script>
        (function(){
            /**
             * Record impressions made by an element
             */
            class RecordImpression{
                /**
                 * Class constructor
                 * @param {HTMLElement} element required
                 * @param {String} category required
                 * @param {String} label required
                 * @param {Int} value optional
                 */
                constructor(element, category, label, value){
                    this.element = element;
                    this.data = {
                        'event_category': category,
                        'event_label': label,
                        'non_interaction': true
                    }
                    if (value !== undefined){
                        this.data.value = value;
                    }
                    this.impressionRecorded = false;
                    this.scrollHandler = event => {
                        this.checkImpression();
                    }
                    window.addEventListener('scroll', this.scrollHandler, {passive: true})
                    this.checkImpression();
                }
                checkImpression(event){
                    if (this.element.getBoundingClientRect().top < window.innerHeight - 40){
                        this.impressionRecorded = true;
                        window.removeEventListener('scroll', this.scrollHandler);
                        gtag('event', 'impression', {
                            'event_category': 'Contact Form',
                            'event_label': 'viewed contact form',
                            'non_interaction': true
                        });
                    }
                }
            }
            const articleFooter = document.querySelector('.article-footer');
            new RecordImpression(articleFooter);
        })();
    </script>
</body>
</html>