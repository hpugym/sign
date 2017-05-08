<div class="page-container">
    <b><a href="{{$paging['next_page_url']}}">&raquo;</a></b>
    {{--{{var_dump($paging)}}--}}
    @foreach($paging['url_list'] as $url=>$val)
        @if($val=='…')
            <a href="javascript:void(0)">…</a>
        @else
            @if($paging['current_page'] == $url)
                <a href="{{$val}}" id="underline">{{$url}}</a>
            @else
                <a href="{{$val}}">{{$url}}</a>
            @endif
        @endif
    @endforeach
    <b><a href="{{$paging['prev_page_url']}}">&laquo;</a></b>
</div>
<style type="text/css">
    .page-container{
        width: 360px;
        height: 40px;
        line-height: 40px;
        font-size: 20px;
        border: 1px solid transparent;
        -webkit-border-radius:4px;
        -moz-border-radius:4px;
        border-radius:4px;
        background-color: white;
    }
    .page-container a{
        background-color: white;
        float: right;
        margin-left: 10px;
    }
    #underline{
        text-decoration: underline;
        color: black;
    }
</style>