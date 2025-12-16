<?php
class SettingsController {
    protected $db;
    public function __construct($db) { $this->db = $db; }

    public function index() {
        $st = $this->db->query("SELECT * FROM settings");
        $settings = [];
        while($r = $st->fetch()) $settings[$r['key_name']] = $r['value_text'];
        require __DIR__ . '/../../resources/views/settings/index.php';
    }

    public function update() {
        $sql = "INSERT OR REPLACE INTO settings (key_name, value_text) VALUES ('clinic_name', :c), ('slot_duration', :s)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':c'=>$_POST['clinic_name'], ':s'=>$_POST['slot_duration']]);
        header('Location: /settings?saved=1');
    }
}