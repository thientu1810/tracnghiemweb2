</div>
</main>
</div>
</div>
<footer class=< footer class="border-top footer bg-dark">
    <div class="container text-center text-light">
    </div>
</footer>
<!-- MDB -->
<!-- <script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"
></script> -->
</body>
</html>

<script>
  //pagination
$(document).ready(function(){

load_data(1);

function load_data(page, query = '')
{
$.ajax({
    url:"fetch.php",
    method:"POST",
    data:{page:page, query:query},
    success:function(data)
    {
    $('#dynamic_content').html(data);
    }
});
}

$(document).on('click', '.page-link', function(){
var page = $(this).data('page_number');
var query = $('#search_box').val();
load_data(page, query);
});

$('#search_box').keyup(function(){
var query = $('#search_box').val();
load_data(1, query);
});

});
</script>