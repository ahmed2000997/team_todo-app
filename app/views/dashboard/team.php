<div class="team-container">
  <div class="team-header">
    <h2>👥 فريقي</h2>
    <button class="add-member" onclick="addMember()">➕ إضافة صديق</button>
  </div>

  <div class="team-list" id="teamList">
    <div class="member-card"><span>Ahmed</span></div>
    <div class="member-card"><span>Adam997</span></div>
    <div class="member-card"><span>Keroum997</span></div>
  </div>
</div>

<script>
function addMember() {
  const name = prompt("👤 أدخل اسم الصديق لإضافته إلى الفريق:");
  if (!name) return;

  const list = document.getElementById("teamList");
  const card = document.createElement("div");
  card.className = "member-card";
  card.innerHTML = `<span>${name}</span>`;
  list.appendChild(card);
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
.team-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.team-header h2 {
  color: #4A6CF7;
  margin: 0;
}
.team-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 15px;
}
.member-card {
  background: #f4f6fb;
  border-radius: 12px;
  padding: 15px;
  text-align: center;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  transition: transform 0.2s ease;
}
.member-card:hover {
  transform: scale(1.05);
}
.member-card span {
  display: block;
  font-size: 1.2em;
  color: #333;
}
.add-member {
  padding: 10px 16px;
  background: #4A6CF7;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s;
}
.add-member:hover {
  background: #3655d9;
}
</style>
