<form method="post" action="{{route('manage.openseminar_1212.updateConfig')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}" />
    문서 작성시 포인트 <input type="text" name="document_point" value="{{$config->get('document_point')}}"> <br/>
    댓글 작성시 포인트 <input type="text" name="comment_point" value="{{$config->get('comment_point')}}"> <br/>
    <br/>
    <button type="submit">설정 변경</button>
</form>