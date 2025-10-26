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
    <label><input type="checkbox" id="selectAllMembers"> تحديد الكل</label>
    <div id="teamBox" class="team-box">
      <p>⏳ جاري تحميل أعضاء الفريق...</p>
    </div>
  </div>
</div>

<script>
// ✅ حذف مهمة
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
   ✅ إضافة مهمة جديدة
   ========================================================== */
function addTask() {
  const title = document.getElementById("taskInput").value.trim();
  const description = document.getElementById("taskDesc").value.trim();

  // جمع أعضاء الفريق المختارين (data-user-id يجب أن يكون معروضاً لكل checkbox)
  const checkedMembers = Array.from(document.querySelectorAll("#teamBox input[type='checkbox']:checked"))
    .map(cb => cb.dataset.userId)
    .filter(id => id !== undefined && id !== null && id !== '');

  if (!title) {
    alert("⚠️ الرجاء إدخال عنوان المهمة");
    return;
  }

  // بناء URLSearchParams بشكل صحيح: append لكل عضو كمفتاح members[]
  const params = new URLSearchParams();
  params.append('action', 'add');
  params.append('title', title);
  params.append('description', description);

  checkedMembers.forEach(memberId => {
    params.append('members[]', memberId); // مهم: members[] لكي تكون مصفوفة في PHP
  });

  // لا تقم بتعيين Content-Type يدوياً عند إرسال URLSearchParams؛ المتصفح يعينه تلقائياً
  fetch("/team_todo-app/app/controllers/HomeController.php", {
    method: "POST",
    body: params
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("✅ تم إضافة المهمة بنجاح");
        document.getElementById("taskInput").value = "";
        document.getElementById("taskDesc").value = "";
        loadData(); // إعادة تحميل لعرض المهمة والأعضاء
      } else {
        alert(data.message || "❌ فشل في إضافة المهمة.");
      }
    })
    .catch(err => {
      console.error(err);
      alert("⚠️ خطأ في الاتصال بالسيرفر.");
    });
}


document.getElementById("addTaskBtn").addEventListener("click", addTask);

/* ==========================================================
   ✅ تحميل الفريق والمهام
   ========================================================== */
function loadData() {
  fetch("/team_todo-app/app/controllers/HomeController.php")
    .then(res => res.json())
    .then(data => {
      const box = document.getElementById("teamBox");
      const taskList = document.getElementById("taskList");
      box.innerHTML = "";
      taskList.innerHTML = "";

      if (!data.success) {
        box.innerHTML = `<p style='color:red;'>${data.message}</p>`;
        return;
      }

      // ✅ عرض الفريق
      if (!data.members.length) {
        box.innerHTML = "<p>❌ لا يوجد أعضاء في فريقك بعد</p>";
      } else {
        data.members.forEach(m => {
          const label = document.createElement("label");
          label.innerHTML = `<input type='checkbox' data-user-id='${m.id_user}'> 👤 ${m.email}`;
          box.appendChild(label);
        });
      }

      // ✅ عرض المهام
      if (!data.tasks.length) {
        taskList.innerHTML = "<li>📭 لا توجد مهام حالياً</li>";
      } else {
        data.tasks.forEach(t => {
          const li = document.createElement("li");
          li.dataset.taskId = t.id;
          const members = (t.members && t.members.length)
            ? `👥 ${t.members.join(', ')}`
            : "👤 لا أعضاء مشاركين";
          li.innerHTML = `
            🟢 <strong>${escapeHtml(t.title)}</strong><br>
            <small>${escapeHtml(t.description || '')}</small><br>
            <em>${members}</em>
            <button class="delete-btn" style="margin-left:10px; color:red; cursor:pointer;">🗑 حذف</button>
          `;
          li.querySelector(".delete-btn").addEventListener("click", (e) => {
            e.preventDefault();
            deleteTaskRemote(t.id, li.querySelector(".delete-btn"));
          });
          taskList.appendChild(li);
        });
      }
    });
}

// ✅ عند تحميل الصفحة
document.addEventListener("DOMContentLoaded", loadData);

// ✅ تحديد الكل
document.getElementById("selectAllMembers").addEventListener("change", function() {
  document.querySelectorAll("#teamBox input[type='checkbox']").forEach(cb => cb.checked = this.checked);
});

// 🔒 حماية النص من XSS
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
.team-box label {
  display: block;
  margin-bottom: 5px;
}
</style>
