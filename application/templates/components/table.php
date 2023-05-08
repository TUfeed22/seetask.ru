<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead>
          <tr>
            <td>#</td>
            <td>Наименование</td>
            <td>Описание</td>
            <td>Статус</td>
            <td>Дата создания</td>
            <td>Автор</td>
          </tr>
          </thead>
          <tbody>
	          <?php
	          foreach ($projects as $project) {
              echo "<tr>";
		          foreach ($project as $key => $value) {
			          echo "<td>$value</td>";
		          }
		          echo "</tr>";
	          }
	          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>