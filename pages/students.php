<?php 
  // session_start();
  include('./backend/database_information.php');
  include('./backend/fetchstudents.php');
?>
<div class="table-container" role="region" aria-label="Student Information Table">
    <header class="table-header">
      <h1>Student Information Management</h1>
      <p>Previously Added Students</p>
    </header>
    <table>
      <thead>
        <tr>
          <th>Student ID</th>
          <th>Name</th>
          <th>Address</th>
          <th>Department</th>
          <th style="text-align:center;">Actions</th>
        </tr>
      </thead>
      <tbody>
        
        <?php  foreach($students as $student): ?>
          <tr>
            <td class="student-id" data-label="Student ID">
                <?= $student['student_id_number']?>
              </td>

              <td data-label="Name">
                <div class="name-cell">
                  <!-- <div class="avatar" aria-hidden="true">M</div> -->
                  <div>
                    <div><strong><?= $student['full_name']?></strong></div>
                    <!-- Optional email -->
                    <!-- <div style="font-size: 0.85rem; color: #64748b;">emailMoExample@email.com</div> -->
                  </div>
                </div>
              </td>

              <td data-label="Address">
                <?= $student['address']?>
              </td>

              <td data-label="Department">
                <span class="department-badge" style="background:#f59e0b;">
                  <?= $student['department']?>
                </span>
              </td>

              <td class="actions" data-label="Actions" style="text-align:center;">
                <button class="action-btn edit-btn" aria-label="Edit <?= $student['full_name']?>">Edit</button>
                <button 
                  class="action-btn delete-btn"
                  aria-label="Delete <?= $student['full_name']?>"
                  onclick="removeStudent(<?= $student['student_id_number']?>)"
                >
                  Delete
                </button>
              </td>
            </tr>

        <?php  endforeach ?>
      </tbody>
    </table>
</div>
