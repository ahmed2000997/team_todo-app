<div class="task-team-section">
  <!-- 🟢 قسم المهام -->
  <div class="task-section">
    <h3>My Tasks</h3>

    <div class="task-input">
      <input type="text" id="taskInput" placeholder="Enter task title">
      <textarea id="taskDesc" placeholder="Enter task description (optional)" rows="2"></textarea>
      <button id="addTaskBtn">Add</button>
    </div>

    <ul id="taskList">
      <li>⏳ جاري تحميل المهام...</li>
    </ul>
  </div>

  <!-- 👥 قسم الفريق -->
  <div class="team-section">
    <h3>Team</h3>
    <div id="teamBox" class="team-box">
      <p>⏳ جاري تحميل أعضاء الفريق...</p>
    </div>
  </div>
</div>

<script>
// ✅ دالة لحذف مهمة من قاعدة البيانات + من الواجهة
function deleteTaskRemote(taskId, buttonElement) {
  let liElement = buttonElement?.closest("li");
  if (!liElement && taskId) liElement = document.querySelector(`li[data-task-id="${taskId}"]`);
  if (!liElement) return console.error("❌ لم يتم العثور على عنصر <li>.");

  if (!confirm("هل أنت متأكد من حذف هذه المهمة؟")) return;

  fetch("/team_todo-app/app/controllers/HomeController.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({ action: "delete", task_id: taskId })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) liElement.remove();
      else alert(data.message || "⚠️ فشل في حذف المهمة.");
    })
    .catch(() => alert("⚠️ فشل الاتصال بالسيرفر."));
}

/* ==========================================================
   ✅ دالة لإضافة مهمة جديدة
   ========================================================== */
function addTask() {
  const titleInput = document.getElementById("taskInput");
  const descInput = document.getElementById("taskDesc");

  const title = titleInput.value.trim();
  const description = descInput.value.trim();

  if (!title) {
    alert("⚠️ الرجاء إدخال عنوان المهمة");
    return;
  }

  fetch("/team_todo-app/app/controllers/HomeController.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
      action: "add",
      title: title,
      description: description
    })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("✅ تم إضافة المهمة بنجاح");
        titleInput.value = "";
        descInput.value = "";

        // 🟢 أضف المهمة الجديدة مباشرة إلى القائمة
        const taskList = document.getElementById("taskList");
        const li = document.createElement("li");
        li.dataset.taskId = "temp-" + Date.now();
        li.innerHTML = `
          🟢 <strong>${escapeHtml(title)}</strong><br>
          <small>${escapeHtml(description)}</small>
          <button class="delete-btn" style="margin-left:10px; color:red; cursor:pointer;">🗑 حذف</button>
        `;

        li.querySelector(".delete-btn").addEventListener("click", (e) => {
          e.preventDefault();
          deleteTaskRemote(li.dataset.taskId, li.querySelector(".delete-btn"));
        });

        taskList.prepend(li);
      } else {
        alert(data.message || "❌ فشل في إضافة المهمة.");
      }
    })
    .catch(() => alert("⚠️ خطأ في الاتصال بالسيرفر."));
}

document.getElementById("addTaskBtn").addEventListener("click", addTask);

/* ==========================================================
   ✅ عند تحميل الصفحة: جلب الفريق والمهام
   ========================================================== */
document.addEventListener("DOMContentLoaded", () => {
  fetch("/team_todo-app/app/controllers/HomeController.php")
    .then(res => res.json())
    .then(data => {
      const taskList = document.getElementById("taskList");
      const box = document.getElementById("teamBox");
      box.innerHTML = "";
      taskList.innerHTML = "";

      if (!data.success) {
        box.innerHTML = `<p style='color:red;'>${data.message}</p>`;
        taskList.innerHTML = "<li style='color:red;'>⚠️ فشل في تحميل البيانات.</li>";
        return;
      }

      // ✅ عرض الفريق
      if (!data.members || data.members.length === 0) {
        box.innerHTML = "<p>❌ لا يوجد أعضاء في فريقك بعد</p>";
      } else {
        data.members.forEach(m => {
          const label = document.createElement("label");
          label.innerHTML = `<input type='checkbox' checked> 👤 ${m.email}`;
          box.appendChild(label);
        });
      }

      // ✅ عرض المهام
      if (!data.tasks || data.tasks.length === 0) {
        taskList.innerHTML = "<li>📭 لا توجد مهام حالياً</li>";
      } else {
        data.tasks.forEach(t => {
          const li = document.createElement("li");
          li.dataset.taskId = t.id;
          li.innerHTML = `
            🟢 <strong>${escapeHtml(t.title)}</strong><br>
            <small>${escapeHtml(t.description || '')}</small>
            <button class="delete-btn" style="margin-left:10px; color:red; cursor:pointer;">🗑 حذف</button>
          `;
          li.querySelector(".delete-btn").addEventListener("click", (e) => {
            e.preventDefault();
            deleteTaskRemote(t.id, li.querySelector(".delete-btn"));
          });
          taskList.appendChild(li);
        });
      }
    })
    .catch(() => {
      document.getElementById("teamBox").innerHTML =
        "<p style='color:red;'>⚠️ فشل في تحميل أعضاء الفريق.</p>";
      document.getElementById("taskList").innerHTML =
        "<li style='color:red;'>⚠️ فشل في تحميل المهام.</li>";
    });
});

// 🔒 دالة أمان لحماية النص من XSS
function escapeHtml(text) {
  if (!text) return "";
  return text.replace(/[&<>"'`=\/]/g, s => ({
    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;',
    "'": '&#39;', '/': '&#x2F;', '`': '&#x60;', '=': '&#x3D;'
  }[s]));
}
</script>

<style>
.task-input {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-bottom: 10px;
}
.task-input input, .task-input textarea {
  width: 100%;
  padding: 8px;
  border-radius: 8px;
  border: 1px solid #ccc;
}
.task-input button {
  width: 120px;
  padding: 8px;
  border: none;
  background-color: #0078ff;
  color: white;
  border-radius: 8px;
  cursor: pointer;
}
.task-input button:hover {
  background-color: #005fcc;
}
</style>
