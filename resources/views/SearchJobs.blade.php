@extends('capas.app')
@section('content')
    <h2>Capture data</h2>
    <button id="btnData" class="btn btn-primary" type="button">Data</button>
@endsection
@section('scripts')
<script>
 $('#btnData').click(function (e) { 
     console.log('valgo');
     
     e.preventDefault();
     let authorizationToken = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiMjczZmEwZmEyYzM2ZWQxYjg2ZDFmNDhmYzYyNjBiMjllMDE0YmQwZTcyODJhNjMzMDEyMzVjNWU4YTUyMTU0YjE3MDkwMzg4OGEwNjExNWQiLCJpYXQiOjE1ODY4MTMyMDksIm5iZiI6MTU4NjgxMzIwOSwiZXhwIjoxNjE4MzQ5MjA4LCJzdWIiOiI3Iiwic2NvcGVzIjpbIioiXX0.SZMSCtD3dpEpRUYM2a1agSb0XLHN6N19GIOpau_MYPvQ8UnymCDMzvJFEJz4xWG-CgGejt04IwWxJMbzs3cWAALskclJqciVTeKN4MMtBL4Qb5dzO1-a0K4rYacaXC_sj--DKXUjvYGt3g7xQyMDEg8kb_K43tDwoWZrorK3YIKCv3YBSD0NyeGTk1NlodpbboaOfdI-dOCE5CdSxqS63aTYCYFqtbNVphg5Mj7UTX_eWzmDIAlWClyj00GMbgNnckfuTcRxp1W1kmYxzEyxHPnnEjzikVuROHx1Ek_rwvyr1AisqklT7WVmyUBPuH1vCd50kb4_W2L6yYQ8aagZtXz5I1n-VAWThUZn12qEjcciUggZedxVrqA1ZRS0wxgYnvEDKJ47Ls1im_9AvBN5sDZydXsJTVliSyD_jfShC1TF3t9U7P3r_-gX08ivBD0VA85ePgRW8KGfnZjKWh3IR0afj5HJyV6BS5LRZRMyd7vM88FrApGqQtg9x47mKz4ScLzS6zMJJWhTL5cjWZ8DLYwUuj7adek0wFgFWwyml70VyHYxepWNIlOsea8fqdsd_88GAtlmNIEJt2NminV78KU-2B_87KfM9INM1OO2-Ho_YBml_L2MT0PjCy4WOmsW2zzovjXyslqgcpijt4JtpRf8W13dWnJjVckV22ZILC0';
    $.ajaxSetup({
    //    header:{"Access-Control-Allow-Origin":"https://fazrenterprise.000webhostapp.com"}
       headers: { 
    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Cookie':'XSRF-TOKEN=eyJpdiI6Ilk2NHF2R3k0TVI0bGhQdlZLXC9ZakFBPT0iLCJ2YWx1ZSI6ImVoT0dxTzBQY0RwZ0JhMGJMZWh5ZXpGRUR1SnRta3grSUVVMFBLTk5lWDlEWjNVVE9XT21SY21GcUxENFF5Mm0iLCJtYWMiOiIxY2MzZjhiMWY0OTA3Mjc2YTBlYzJjYzg0YmVmN2RiNGEwOTM2OWMxNjg0NGQxYTAxYWEwNzRlNzgwMDg0Y2Y2In0%3D; laravel_session=eyJpdiI6IlFTV1k3TThvYmhyMXlnZzk5VlUxQ3c9PSIsInZhbHVlIjoicm5YWGMxR2pvQXU4UlFBNEtBRTFuNjl1WW96bHlKSUMwcUx2R1Y3Tlh1ZWdsU2M5QUFlSjVZVWxmQm5HUkw2VyIsIm1hYyI6ImIzNGJmNGMwN2FhYzc1M2IwODcwNDU4YmNiZDBhYjkwZWFiZTQwMjhhN2Q0YmYzZTFhZjdmZTE4MGE1OGY2MDUifQ%3D%3D',
        'Host':'<calculated when request is sent>',
        'Accept':'*/*',
        'Accept-Encoding':'gzip, deflate, br',
        'Connection':'keep-alive',
        'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiMjczZmEwZmEyYzM2ZWQxYjg2ZDFmNDhmYzYyNjBiMjllMDE0YmQwZTcyODJhNjMzMDEyMzVjNWU4YTUyMTU0YjE3MDkwMzg4OGEwNjExNWQiLCJpYXQiOjE1ODY4MTMyMDksIm5iZiI6MTU4NjgxMzIwOSwiZXhwIjoxNjE4MzQ5MjA4LCJzdWIiOiI3Iiwic2NvcGVzIjpbIioiXX0.SZMSCtD3dpEpRUYM2a1agSb0XLHN6N19GIOpau_MYPvQ8UnymCDMzvJFEJz4xWG-CgGejt04IwWxJMbzs3cWAALskclJqciVTeKN4MMtBL4Qb5dzO1-a0K4rYacaXC_sj--DKXUjvYGt3g7xQyMDEg8kb_K43tDwoWZrorK3YIKCv3YBSD0NyeGTk1NlodpbboaOfdI-dOCE5CdSxqS63aTYCYFqtbNVphg5Mj7UTX_eWzmDIAlWClyj00GMbgNnckfuTcRxp1W1kmYxzEyxHPnnEjzikVuROHx1Ek_rwvyr1AisqklT7WVmyUBPuH1vCd50kb4_W2L6yYQ8aagZtXz5I1n-VAWThUZn12qEjcciUggZedxVrqA1ZRS0wxgYnvEDKJ47Ls1im_9AvBN5sDZydXsJTVliSyD_jfShC1TF3t9U7P3r_-gX08ivBD0VA85ePgRW8KGfnZjKWh3IR0afj5HJyV6BS5LRZRMyd7vM88FrApGqQtg9x47mKz4ScLzS6zMJJWhTL5cjWZ8DLYwUuj7adek0wFgFWwyml70VyHYxepWNIlOsea8fqdsd_88GAtlmNIEJt2NminV78KU-2B_87KfM9INM1OO2-Ho_YBml_L2MT0PjCy4WOmsW2zzovjXyslqgcpijt4JtpRf8W13dWnJjVckV22ZILC0',
        // 'Content-Type':'application/json',
        // 'Content-Length':'735',
        
        // 'Cache-Control':'no-cache, private',
        // 'Vary':'Authorization',
        // 'X-RateLimit-Limit':'60',
        // 'X-RateLimit-Remaining':'59',
        // 'Server':'awex',
        // 'X-Xss-Protection':'1; mode=block',
        // 'X-Content-Type-Options':'nosniff',
        // 'X-Request-ID':'32a1bd638a94d57f6f7e44d2731db8a4'
         }
    });

   $.ajax({
       type: "GET",
    //    beforeSend: function(request) {
    //     request.setRequestHeader("Authorization", authorizationToken);
    //     },
       url: "https://fazrenterprise.000webhostapp.com/api/user",
       data: null,
       success: function (response) {
           console.log(response);
           alert(response);  
       },
       error:function(err){
           console.log(err);
       }
   });
 });
</script>
@endsection