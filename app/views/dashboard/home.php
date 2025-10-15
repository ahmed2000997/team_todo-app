<div class="task-team-section">
  <!-- قسم المهام -->
  <div class="task-section">
    <h3>My Tasks</h3>
    <div class="task-input">
      <input type="text" id="taskInput" placeholder="Enter new Task">
      <button onclick="addTask()">Add</button>
    </div>
    <ul id="taskList">
      <li>🟢 Design login page</li>
      <li>🟡 Connect to database</li>
    </ul>
  </div>

  <!-- قسم الفريق -->
  <div class="team-section">
    <h3>Team</h3>
    <div id="teamBox" class="team-box">
      <p>⏳ جاري تحميل أعضاء الفريق...</p>
    </div>
  </div>
</div>

<script>
// ✅ عند تحميل الصفحة، جلب الفريق من السيرفر
document.addEventListener("DOMContentLoaded", () => {
  fetch("/team_todo-app/app/controllers/HomeController.php")
    .then(res => res.json())
    .then(data => {
      const box = document.getElementById("teamBox");
      box.innerHTML = "";

      if (!data.success) {
        box.innerHTML = `<p style='color:red;'>${data.message}</p>`;
        return;
      }

      if (data.members.length === 0) {
        box.innerHTML = "<p>❌ لا يوجد أعضاء في فريقك بعد</p>";
        return;
      }

      data.members.forEach(m => {
        const label = document.createElement("label");
        label.innerHTML = `<input type="checkbox" checked> 👤 ${m.email}`;
        box.appendChild(label);
      });
    })
    .catch(err => {
      console.error(err);
      document.getElementById("teamBox").innerHTML =
        "<p style='color:red;'>⚠️ فشل في تحميل أعضاء الفريق.</p>";
    });
});
</script>
