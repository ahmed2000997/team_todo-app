<?php
if (!isset($_SESSION)) session_start();
$user = $_SESSION['user'];
?>

<div class="team-container">
  <div class="team-header">
    <h2>👥 فريقي</h2>
  </div>

  <!-- 🔍 البحث عن صديق -->
  <div class="search-section">
    <input type="text" id="friendEmail" placeholder="🔍 أدخل البريد الإلكتروني لإضافة صديق...">
    <button onclick="searchFriend()">بحث</button>
  </div>

  <div id="results" class="results-box"></div>

  <!-- 📋 قائمة الفريق -->
  <h3>أعضاء الفريق الحاليين</h3>
  <div id="teamList" class="team-list">
    <p>⏳ جاري تحميل أعضاء فريقك...</p>
  </div>
</div>

<script>
// ✅ تحميل أعضاء الفريق عند فتح الصفحة
document.addEventListener("DOMContentLoaded", loadTeam);

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

// ✅ البحث عن صديق بالبريد
function searchFriend() {
  const email = document.getElementById("friendEmail").value.trim();
  if (!email) return alert("⚠️ الرجاء إدخال بريد إلكتروني للبحث");

  fetch(`../../../app/controllers/team.php?action=search&email=${encodeURIComponent(email)}`)
    .then(res => res.json())
    .then(users => {
      const box = document.getElementById("results");
      box.innerHTML = "";
      if (users.length === 0) {
        box.innerHTML = "<p>❌ لا يوجد مستخدم بهذا البريد</p>";
        return;
      }

      users.forEach(u => {
        const card = document.createElement("div");
        card.className = "user-card";
        card.innerHTML = `
          <span>📧 ${u.email}</span>
          <button onclick="addToTeam(${u.id_user})">➕ إضافة</button>
        `;
        box.appendChild(card);
      });
    });
}

// ✅ إضافة صديق للفريق
function addToTeam(id) {
  fetch('../../../app/controllers/team.php', {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify({ friend_id: id })
  })
  .then(res => res.json())
  .then(d => {
    alert(d.message);
    if (d.success) loadTeam(); // إعادة تحميل القائمة
  });
}

// ✅ إزالة عضو من الفريق
function removeFromTeam(id) {
  if (!confirm("هل تريد إزالة هذا العضو من الفريق؟")) return;

  fetch(`../../../app/controllers/team.php?action=remove&id=${id}`)
    .then(res => res.json())
    .then(d => {
      alert(d.message);
      if (d.success) loadTeam();
    });
}
</script>

<style>
.team-container {
  display: flex;
  flex-direction: column;
  gap: 20px;
  background: #fff;
  border-radius: 16px;
  padding: 30px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.team-header h2 {
  color: #4A6CF7;
  margin: 0;
}
.search-section {
  display: flex;
  gap: 10px;
}
.search-section input {
  flex: 1;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
}
.search-section button {
  background: #4A6CF7;
  color: #fff;
  border: none;
  padding: 10px 16px;
  border-radius: 8px;
  cursor: pointer;
}
.results-box, .team-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.user-card, .member-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #f4f6fb;
  border-radius: 8px;
  padding: 10px 15px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.user-card button, .remove-btn {
  background: #1e90ff;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 6px;
  cursor: pointer;
}
.remove-btn {
  background: #ff4d4f;
}
</style>
