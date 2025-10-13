// ✅ إضافة مهمة جديدة إلى القائمة
function addTask() {
  const input = document.getElementById("taskInput");
  const taskList = document.getElementById("taskList");

  const taskText = input.value.trim();
  if (!taskText) {
    alert("الرجاء إدخال مهمة أولاً ✅");
    return;
  }

  // إنشاء عنصر المهمة
  const li = document.createElement("li");
  li.classList.add("task-item");
  li.innerHTML = `
    <span>🟢 ${taskText}</span>
    <button class="delete-btn" onclick="deleteTask(this)">🗑️</button>
  `;

  // إضافتها إلى القائمة
  taskList.appendChild(li);

  // تفريغ الحقل
  input.value = "";
}

// ✅ حذف مهمة من القائمة
function deleteTask(button) {
  const li = button.parentElement;
  li.remove();
}

// ✅ التنقل بين الصفحات داخل لوحة التحكم
function navigate(page) {
  window.location.href = page;
}
