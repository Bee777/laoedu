<script type="text/javascript">
    var baseUrl = '{{ url('/') }}';
    var banners = {!! $banners !!};
    var latest_news = {!! $latest_news !!};

    var news =  {!! $news!!};
    var activities =  {posts: {}, mostViews: [], comingEvents: []};
    var scholarships =  {posts: {}, mostViews: [], comingEvents: []};
    var instituteCategories = [];

</script>
