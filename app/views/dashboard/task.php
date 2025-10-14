<div class="task-container">
  <div class="content-header">
    <h2>Tasks Overview</h2>
  </div>

  <div class="task-team-section">
    <!-- قسم المهام -->
    <div class="task-section">
      <h3>All Tasks</h3>
      <div class="task-input">
        <input type="text" id="taskInput" placeholder="Enter a new task">
        <button onclick="addTask()">Add</button>
      </div>

      <ul id="taskList">
        <li>🟢 Design login page</li>
        <li>🟡 Fix database connection</li>
        <li>🔵 Add validation for register form</li>
      </ul>
    </div>

    <!-- قسم أعضاء الفريق -->
    <div class="team-section">
      <h3>Assigned Members</h3>
      <div class="team-box">
        <label><input type="checkbox" checked> 👤 Ahmed</label>
        <label><input type="checkbox" checked> 👤 Adam997</label>
        <label><input type="checkbox"> 👤 Keroum997</label>
      </div>
    </div>
  </div>
</div>
