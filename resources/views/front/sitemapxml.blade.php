@php 
use App\Models\DynamicFieldValues;
use App\Models\Blog;
use App\Models\TopCategory;
use App\Models\ListingMaster;
echo '<?xml version="1.0" encoding="utf-8"?>';
@endphp
  @if($type=='final')
    <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
      <sitemap>
        <loc>{{url('sitemap_staticpage.xml')}}</loc>
      </sitemap>
      <sitemap>
        <loc>{{url('sitemap_blog.xml')}}</loc>
      </sitemap>
      <sitemap>
        <loc>{{url('sitemap_listing.xml')}}</loc>
      </sitemap>
    </sitemapindex>
  @else
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    @if($type=='static')
      <url>
        <loc>{{url('horses-for-sale')}}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      <url>
        <loc>{{ url('transport-for-horses') }}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      <url>
        <loc>{{ url('property-for-sale') }}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      <url>
        <loc>{{ url('saddlery-and-tack') }}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      <url>
        <loc>{{ url('safety-centre') }}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      <url>
        <loc>{{ url('scams-selling') }}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      <url>
        <loc>{{ url('scams-buying') }}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      <url>
        <loc>{{ url('about') }}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      <url>
        <loc>{{ url('imprint') }}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      <url>
        <loc>{{ url('terms-a-conditions') }}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      <url>
        <loc>{{ url('rights_of_withdrawal') }}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      <url>
        <loc>{{ url('help') }}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      <url>
        <loc>{{ url('privacy-policy') }}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      <url>
        <loc>{{ url('contact_enquiry') }}</loc>
        <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
    @elseif($type=='blog')
      <url>
       <loc>{{url('all-news')}}</loc>
       <lastmod>{{ date("Y-m-d")}}</lastmod>
      </url>
      @php
        $blogs = Blog::where(['is_delete' => '0','is_active'=> '1'])->get();
      @endphp
      @foreach($blogs as $key => $blog)
        <url>
         <loc>{{ url('horse-articles-news')}}{{'/'}}{{$blog->slug}}</loc>
         <lastmod>{{ date("Y-m-d")}}</lastmod>
        </url>
      @endforeach
    @elseif($type=='listing')
      @php
        $listing_datas = ListingMaster::where(['is_active' => '1','is_approved' => '1','is_delete' => '0'])->get();
      @endphp
      @foreach($listing_datas as $key => $listing_data)
        <url>
         <loc>{{ url('ad')}}/{{$listing_data->ad_id.'-'.$listing_data->slug}}</loc>
         <lastmod>{{ date("Y-m-d")}}</lastmod>
        </url>
      @endforeach
    @endif
    </urlset>
  @endif