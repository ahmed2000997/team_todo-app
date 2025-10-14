<div class="settings-container">
  <div class="content-header">
    <h2>⚙️ الإعدادات</h2>
  </div>

  <div class="settings-sections">
    <!-- إعدادات الملف الشخصي -->
    <div class="settings-section">
      <h3>👤 الملف الشخصي</h3>
      <form action="#" method="post" class="settings-form">
        <label>البريد الإلكتروني:</label>
        <input type="email" value="<?= htmlspecialchars($user['email']); ?>" disabled>

        <label>تغيير كلمة المرور:</label>
        <input type="password" placeholder="أدخل كلمة مرور جديدة">

        <button type="submit">💾 تحديث</button>
      </form>
    </div>

    <!-- إعدادات المظهر -->
    <div class="settings-section">
      <h3>🎨 المظهر</h3>
      <div class="theme-options">
        <label><input type="radio" name="theme" checked> 🌞 الوضع الفاتح</label>
        <label><input type="radio" name="theme"> 🌙 الوضع الداكن</label>
      </div>
    </div>
  </div>
</div>

<style>
.settings-container {
  background: #fff;
  border-radius: 16px;
  padding: 30px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.08);
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.settings-sections {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 25px;
}

.settings-section {
  background: #f7f9fc;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.settings-section h3 {
  color: #4A6CF7;
  margin-bottom: 15px;
}

.settings-form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.settings-form label {
  font-weight: bold;
  color: #333;
}

.settings-form input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 6px;
}

.settings-form button {
  background: #4A6CF7;
  color: #fff;
  border: none;
  padding: 10px;
  border-radius: 8px;
  cursor: pointer;
  margin-top: 10px;
  transition: background 0.3s;
}

.settings-form button:hover {
  background: #3655d9;
}

.theme-options label {
  display: block;
  margin-bottom: 10px;
  cursor: pointer;
}
</style>
