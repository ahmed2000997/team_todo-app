<?php
if (!isset($_SESSION)) session_start();
$user = $_SESSION['user'];
?>

<div class="team-container">
  <div class="team-header">
    <h2>👥 فريقي</h2>
  </div>

  <!-- 🔍 البحث مع الإكمال التلقائي -->
  <div class="search-section">
    <input type="text" id="friendEmail" placeholder="🔍 أدخل البريد الإلكتروني لإضافة صديق...">
    <div id="suggestions" class="suggestions-box"></div>
  </div>

  <div id="results" class="results-box"></div>

  <!-- 📋 قائمة الفريق -->
  <h3>أعضاء الفريق الحاليين</h3>
  <div id="teamList" class="team-list">
    <p>⏳ جاري تحميل أعضاء فريقك...</p>
  </div>
</div>

<!-- ✅ Toast notifications -->
<div id="toast-container"></div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  loadTeam();
  const input = document.getElementById("friendEmail");

  // ✅ استدعاء الإكمال التلقائي أثناء الكتابة
  input.addEventListener("input", () => {
    const query = input.value.trim();
    const box = document.getElementById("suggestions");

    if (query.length < 2) {
      box.innerHTML = "";
      box.style.display = "none";
      return;
    }

    fetch(`../../../app/controllers/team.php?action=autocomplete&email=${encodeURIComponent(query)}`)
      .then(res => res.json())
      .then(users => {
        box.innerHTML = "";
        if (users.length === 0) {
          box.style.display = "none";
          return;
        }

        users.forEach(u => {
          const item = document.createElement("div");
          item.className = "suggestion-item";
          item.textContent = u.email;
          item.onclick = () => {
            input.value = u.email;
            box.innerHTML = "";
            box.style.display = "none";
            showUserCard(u);
          };
          box.appendChild(item);
        });

        box.style.display = "block";
      });
  });

  // ✅ إخفاء القائمة عند الضغط خارجها
  document.addEventListener("click", (e) => {
    if (!document.querySelector(".search-section").contains(e.target)) {
      document.getElementById("suggestions").style.display = "none";
    }
  });
});

// ✅ عرض المستخدم بعد اختياره من الاقتراحات
function showUserCard(u) {
  const box = document.getElementById("results");
  box.innerHTML = `
    <div class="user-card">
      <span>📧 ${u.email}</span>
      <button onclick="addToTeam(${u.id_user})">➕ إضافة</button>
    </div>
  `;
}

// ✅ تحميل أعضاء الفريق
function loadTeam() {
  fetch("../../../app/controllers/team.php?action=list")
    .then(res => res.json())
    .then(members => {
      const list = document.getElementById("teamList");
      list.innerHTML = "";

      if (members.length === 0) {
        list.innerHTML = "<p>❌ لا يوجد أعضاء في فريقك بعد</p>";
        return;
      }

      members.forEach(m => {
        const card = document.createElement("div");
        card.className = "member-card";
        card.innerHTML = `
          <span>👤 ${m.email}</span>
          <button class="remove-btn" onclick="removeFromTeam(${m.id_user})">❌ إزالة</button>
        `;
        list.appendChild(card);
      });
    });
}

// ✅ إضافة عضو
function addToTeam(id) {
  fetch('../../../app/controllers/team.php', {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify({ friend_id: id })
  })
  .then(res => res.json())
  .then(d => {
    showToast(d.message, d.success ? "success" : "error");
    if (d.success) loadTeam();
  });
}

// ✅ إزالة عضو
function removeFromTeam(id) {
  if (!confirm("هل تريد إزالة هذا العضو من الفريق؟")) return;

  fetch(`../../../app/controllers/team.php?action=remove&id=${id}`)
    .then(res => res.json())
    .then(d => {
      showToast(d.message, d.success ? "success" : "error");
      if (d.success) loadTeam();
    });
}

// ✅ Toast أنيق
function showToast(message, type = "info") {
  const toast = document.createElement("div");
  toast.className = `toast ${type}`;
  toast.textContent = message;

  document.getElementById("toast-container").appendChild(toast);

  setTimeout(() => { toast.classList.add("show"); }, 100);
  setTimeout(() => {
    toast.classList.remove("show");
    setTimeout(() => toast.remove(), 400);
  }, 3000);
}
</script>

<style>
.team-container {
  background: #fff;
  border-radius: 16px;
  padding: 30px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  gap: 20px;
}
.team-header h2 {
  color: #4A6CF7;
  margin: 0;
}
.search-section {
  position: relative;
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.search-section input {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
}
.suggestions-box {
  display: none;
  position: absolute;
  top: 42px;
  width: 100%;
  background: white;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  z-index: 10;
}
.suggestion-item {
  padding: 8px 12px;
  cursor: pointer;
  transition: background 0.2s;
}
.suggestion-item:hover {
  background: #f0f3ff;
}
.user-card, .member-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #f4f6fb;
  border-radius: 8px;
  padding: 10px 15px;
}
.user-card button, .remove-btn {
  background: #4A6CF7;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 6px;
  cursor: pointer;
}
.remove-btn {
  background: #ff4d4f;
}

/* Toasts */
#toast-container {
  position: fixed;
  top: 20px;
  right: 20px;
  display: flex;
  flex-direction: column;
  gap: 10px;
  z-index: 9999;
}
.toast {
  opacity: 0;
  transform: translateY(-20px);
  background: #333;
  color: white;
  padding: 12px 18px;
  border-radius: 8px;
  font-size: 15px;
  min-width: 220px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.2);
  transition: all 0.4s ease;
}
.toast.show {
  opacity: 1;
  transform: translateY(0);
}
.toast.success { background: #2ecc71; }
.toast.error { background: #e74c3c; }
.toast.info { background: #3498db; }
</style>
