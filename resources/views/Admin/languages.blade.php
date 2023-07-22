
<style>
    .fixed-con {
        z-index: 9724790009779558!important;
        background-color: #f7f8fc;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        overflow-y: auto;
    }
    .VIpgJd-ZVi9od-aZ2wEe-wOHMyf{
        z-index: 9724790009779!important;
        top:0;
        left:unset;
        right:-5px;
        display:none!important;
        border-radius:50%;
        border:2px solid gold;
    }
    .VIpgJd-ZVi9od-aZ2wEe-OiiCO{
        width:80px;
        height:80px;
    }
    /*hide google translate link | logo | banner-frame */
    .goog-logo-link,.gskiptranslate,.goog-te-gadget span,.goog-te-banner-frame,#goog-gt-tt, .goog-te-balloon-frame,div#goog-gt-{
        display: none!important;
    }
    .goog-te-gadget {
        color: transparent!important;
        font-size:0px;
    }

    .goog-text-highlight {
        background: none !important;
        box-shadow: none !important;
    }

    /*google translate Dropdown */
    #google_translate_element{
        display: flex;
        justify-content: center;
        align-items: center;
        column-gap: 6px;
    }
    #google_translate_element img{
        width: 100%;
        max-width: 30px;
    }
    #google_translate_element select{
        color: #000;
        font-weight: 600;
        background-color: #fff;
        border: none;
        border-radius:3px;
        padding:6px 8px
    }
    .VIpgJd-ZVi9od-ORHb{
        display: none !important;
    }
    .VIpgJd-ZVi9od-ORHb-OEVmcd{
        display: none !important;
        height: 0px !important;
    }
    .goog-te-banner-frame{
        display:none !important;
    }
    .goog-logo-link{
        display:none !important;
    }
    .goog-te-gadget{
        color:#fff!important;
        background-color: transparent !important;
    }#goog-gt-tt, .goog-te-balloon-frame
     {
         display: none !important;
     }
    .goog-text-highlight
    {
        background: none !important;
        box-shadow: none !important;
    }
</style>
<style>
    .shadow::before,
    .shadow::after {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        background: linear-gradient(45deg,red,blue,green,yellow,#e11d74,black,#ffff00,#aa0000);
        background-size: 400%;
        width: calc(100% + 4px);
        height: calc(100% + 4px);
        z-index: -1;
        animation: animate 25s linear infinite;
    }

    .shadow::after {
        filter: blur(25px);
    }

    @keyframes animate {
        0% {
            background-position: 0 0;
        }

        50% {
            background-position: 400% 0;
        }

        100% {
            background-position: 0 0;
        }
    }

</style>
<div id="google_translate_element" style="">  <img src="{{asset('admin/images/language.jpg')}}" alt=""></div>
<br>

<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            autoDisplay: 'true',
            includedLanguages:'en,hi,te,ta,mr,gu,pa',
            layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
        }, 'google_translate_element');
    }
</script>


<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
