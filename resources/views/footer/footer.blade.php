<div class="footer-background">

    <div class="container">
        <div class="footer-section col-sm-5">
            <div class="footer-title">
                Affiliate Disclaimer
            </div>
            <div class="footer-text">
                CouplesCorner.co.uk is a participant in the Amazon Services LLC Associates Program, an affiliate advertising program designed to provide a means for sites to earn advertising fees by advertising and linking to amazon.co.uk.
            </div>
        </div>
        <div class="footer-section col-sm-5">

            <div class="footer-title">
                Pages
            </div>
            <div class="footer-text">
                <ul class="footer">
                    @if ($data['footer'] == null)
                    No footer menu set - Create a menu named footer-menu in Appearance/Menus
                    @else
                    @foreach ($data['footer'] as $footer_item) 
                    <li><a href='{{ $footer_item->slug}}'>{{ $footer_item->name}}</a>
                    @endforeach
                    @endif
                </ul>
            </div>

        </div>
        <div class="footer-section col-sm-2">
        </div>
    </div>

</div>
<div class="footer-background-second">
    <div class="container">
    <div class="footer-section-second col-sm-12">
        <div class="footer-title-second">
               CouplesCorner.co.uk © Copyright 2017 | All Rights Reserved
               <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
            </div>
    </div>
     </div>
</div>  
    
<script src="//z-na.amazon-adsystem.com/widgets/onejs?MarketPlace=US&adInstanceId=436513e2-8bba-4fde-9969-40c4155566c9"></script>
