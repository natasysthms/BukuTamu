
CREATE TABLE IF NOT EXISTS login_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    username VARCHAR(50) NOT NULL,
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);


CREATE INDEX idx_entries_timestamp ON entries(timestamp);
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_login_logs_user ON login_logs(user_id);
