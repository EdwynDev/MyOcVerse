-- MyOCVerse Database Schema

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255),
    banner VARCHAR(255),
    bio TEXT,
    external_links JSON,
    xp INT DEFAULT 0,
    level INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP NULL
);

-- Table des badges
CREATE TABLE badges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(50),
    color VARCHAR(20),
    requirement_type VARCHAR(50),
    requirement_value INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des badges utilisateurs
CREATE TABLE user_badges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    badge_id INT NOT NULL,
    earned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_badge (user_id, badge_id)
);

-- Table des univers
CREATE TABLE universes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    genre VARCHAR(50),
    description TEXT,
    technology_level VARCHAR(50),
    magic_system TEXT,
    geography TEXT,
    history TEXT,
    factions TEXT,
    rules TEXT,
    cover_image VARCHAR(255),
    privacy ENUM('public', 'private', 'friends') DEFAULT 'public',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_privacy (privacy),
    INDEX idx_created_at (created_at)
);

-- Table des races
CREATE TABLE races (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    universe_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    physical_traits TEXT,
    abilities TEXT,
    culture TEXT,
    lifespan VARCHAR(100),
    habitat TEXT,
    weaknesses TEXT,
    image VARCHAR(255),
    privacy ENUM('public', 'private', 'friends') DEFAULT 'public',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (universe_id) REFERENCES universes(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_universe_id (universe_id),
    INDEX idx_privacy (privacy)
);

-- Table des personnages originaux (OC)
CREATE TABLE ocs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    universe_id INT,
    race_id INT,
    name VARCHAR(100) NOT NULL,
    gender VARCHAR(20),
    age VARCHAR(50),
    avatar VARCHAR(255),
    gallery JSON,
    physical_description TEXT,
    mental_description TEXT,
    background TEXT,
    abilities TEXT,
    relationships TEXT,
    timeline JSON,
    attributes JSON,
    privacy ENUM('public', 'private', 'friends') DEFAULT 'public',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (universe_id) REFERENCES universes(id) ON DELETE SET NULL,
    FOREIGN KEY (race_id) REFERENCES races(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_universe_id (universe_id),
    INDEX idx_race_id (race_id),
    INDEX idx_privacy (privacy),
    INDEX idx_created_at (created_at)
);

-- Table des likes
CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content_type ENUM('oc', 'universe', 'race', 'comment') NOT NULL,
    content_id INT NOT NULL,
    liked_user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (liked_user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_like (user_id, content_type, content_id),
    INDEX idx_content (content_type, content_id),
    INDEX idx_liked_user (liked_user_id)
);

-- Table des commentaires
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content_type ENUM('oc', 'universe', 'race') NOT NULL,
    content_id INT NOT NULL,
    parent_id INT,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE,
    INDEX idx_content (content_type, content_id),
    INDEX idx_user_id (user_id),
    INDEX idx_parent_id (parent_id)
);

-- Table des favoris
CREATE TABLE favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content_type ENUM('oc', 'universe', 'race') NOT NULL,
    content_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_favorite (user_id, content_type, content_id),
    INDEX idx_user_id (user_id),
    INDEX idx_content (content_type, content_id)
);

-- Table des collections
CREATE TABLE collections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    privacy ENUM('public', 'private', 'friends') DEFAULT 'public',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_privacy (privacy)
);

-- Table des éléments de collection
CREATE TABLE collection_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    collection_id INT NOT NULL,
    content_type ENUM('oc', 'universe', 'race') NOT NULL,
    content_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (collection_id) REFERENCES collections(id) ON DELETE CASCADE,
    UNIQUE KEY unique_collection_item (collection_id, content_type, content_id),
    INDEX idx_collection_id (collection_id)
);

-- Table des événements
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    type ENUM('contest', 'challenge', 'collaboration') NOT NULL,
    theme VARCHAR(100),
    rules TEXT,
    start_date DATE,
    end_date DATE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_type (type),
    INDEX idx_dates (start_date, end_date),
    INDEX idx_active (is_active)
);

-- Table des participations aux événements
CREATE TABLE event_participations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    content_type ENUM('oc', 'universe', 'race') NOT NULL,
    content_id INT NOT NULL,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_participation (event_id, user_id, content_type, content_id),
    INDEX idx_event_id (event_id),
    INDEX idx_user_id (user_id)
);

-- Table des votes pour les événements
CREATE TABLE event_votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    voter_id INT NOT NULL,
    participation_id INT NOT NULL,
    vote_value INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (voter_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (participation_id) REFERENCES event_participations(id) ON DELETE CASCADE,
    UNIQUE KEY unique_vote (event_id, voter_id, participation_id),
    INDEX idx_event_id (event_id),
    INDEX idx_participation_id (participation_id)
);

-- Table des notifications
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    title VARCHAR(200) NOT NULL,
    message TEXT,
    data JSON,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_is_read (is_read),
    INDEX idx_created_at (created_at)
);

-- Table des relations d'amitié
CREATE TABLE friendships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    requester_id INT NOT NULL,
    addressee_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'declined', 'blocked') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (requester_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (addressee_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_friendship (requester_id, addressee_id),
    INDEX idx_requester (requester_id),
    INDEX idx_addressee (addressee_id),
    INDEX idx_status (status)
);

-- Table des messages privés
CREATE TABLE private_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    recipient_id INT NOT NULL,
    subject VARCHAR(200),
    content TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (recipient_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_sender (sender_id),
    INDEX idx_recipient (recipient_id),
    INDEX idx_is_read (is_read),
    INDEX idx_created_at (created_at)
);

-- Table des tags
CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    color VARCHAR(20) DEFAULT '#6b7280',
    usage_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_name (name),
    INDEX idx_usage_count (usage_count)
);

-- Table des tags de contenu
CREATE TABLE content_tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tag_id INT NOT NULL,
    content_type ENUM('oc', 'universe', 'race') NOT NULL,
    content_id INT NOT NULL,
    tagged_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE,
    UNIQUE KEY unique_content_tag (tag_id, content_type, content_id),
    INDEX idx_tag_id (tag_id),
    INDEX idx_content (content_type, content_id)
);

-- Table des paramètres utilisateur
CREATE TABLE user_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    setting_key VARCHAR(50) NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_setting (user_id, setting_key),
    INDEX idx_user_id (user_id)
);

-- Insertion des badges par défaut
INSERT INTO badges (name, description, icon, color, requirement_type, requirement_value) VALUES
('Bienvenue', 'Premier badge obtenu lors de l\'inscription', 'fas fa-star', 'yellow', 'registration', 1),
('Créateur', 'Créez votre premier OC', 'fas fa-user-plus', 'blue', 'oc_created', 1),
('Prolifique', 'Créez 10 OC', 'fas fa-users', 'purple', 'oc_created', 10),
('Légendaire', 'Créez 50 OC', 'fas fa-crown', 'gold', 'oc_created', 50),
('Architecte', 'Créez votre premier univers', 'fas fa-globe', 'green', 'universe_created', 1),
('Démiurge', 'Créez 5 univers', 'fas fa-mountain', 'teal', 'universe_created', 5),
('Généticien', 'Créez votre première race', 'fas fa-dna', 'orange', 'race_created', 1),
('Évolutionniste', 'Créez 10 races', 'fas fa-leaf', 'lime', 'race_created', 10),
('Populaire', 'Recevez 100 likes', 'fas fa-heart', 'pink', 'likes_received', 100),
('Vedette', 'Recevez 500 likes', 'fas fa-fire', 'red', 'likes_received', 500),
('Vétéran', 'Membre depuis 1 an', 'fas fa-clock', 'gray', 'membership_days', 365),
('Ancien', 'Membre depuis 2 ans', 'fas fa-hourglass', 'silver', 'membership_days', 730);

-- Insertion d'événements exemples
INSERT INTO events (title, description, type, theme, rules, start_date, end_date, is_active) VALUES
('Défi Aquatique', 'Créez un OC lié à l\'élément eau', 'challenge', 'Aquatique', 'Votre personnage doit avoir un lien avec l\'eau (pouvoirs, origine, habitat...)', '2024-01-01', '2024-01-31', TRUE),
('Concours Fantasy', 'Meilleur univers fantasy', 'contest', 'Fantasy', 'Créez un univers fantasy original avec ses propres règles', '2024-02-01', '2024-02-28', TRUE),
('Collaboration Sci-Fi', 'Créons ensemble un univers de science-fiction', 'collaboration', 'Science-Fiction', 'Travaillez en équipe pour créer un univers cohérent', '2024-03-01', '2024-03-31', TRUE);

-- Vues pour les statistiques
CREATE VIEW user_stats AS
SELECT 
    u.id,
    u.username,
    u.xp,
    u.level,
    COUNT(DISTINCT o.id) as oc_count,
    COUNT(DISTINCT un.id) as universe_count,
    COUNT(DISTINCT r.id) as race_count,
    COUNT(DISTINCT l.id) as likes_received,
    COUNT(DISTINCT c.id) as comments_made
FROM users u
LEFT JOIN ocs o ON u.id = o.user_id
LEFT JOIN universes un ON u.id = un.user_id
LEFT JOIN races r ON u.id = r.user_id
LEFT JOIN likes l ON u.id = l.liked_user_id
LEFT JOIN comments c ON u.id = c.user_id
GROUP BY u.id, u.username, u.xp, u.level;

-- Triggers pour la gamification
DELIMITER //

CREATE TRIGGER after_oc_insert
AFTER INSERT ON ocs
FOR EACH ROW
BEGIN
    UPDATE users SET xp = xp + 50 WHERE id = NEW.user_id;
END //

CREATE TRIGGER after_universe_insert
AFTER INSERT ON universes
FOR EACH ROW
BEGIN
    UPDATE users SET xp = xp + 100 WHERE id = NEW.user_id;
END //

CREATE TRIGGER after_race_insert
AFTER INSERT ON races
FOR EACH ROW
BEGIN
    UPDATE users SET xp = xp + 75 WHERE id = NEW.user_id;
END //

CREATE TRIGGER after_comment_insert
AFTER INSERT ON comments
FOR EACH ROW
BEGIN
    UPDATE users SET xp = xp + 10 WHERE id = NEW.user_id;
END //

CREATE TRIGGER after_like_insert
AFTER INSERT ON likes
FOR EACH ROW
BEGIN
    UPDATE users SET xp = xp + 5 WHERE id = NEW.liked_user_id;
END //

CREATE TRIGGER update_user_level
AFTER UPDATE ON users
FOR EACH ROW
BEGIN
    IF NEW.xp != OLD.xp THEN
        UPDATE users SET level = FLOOR(NEW.xp / 1000) + 1 WHERE id = NEW.id;
    END IF;
END //

DELIMITER ;

-- Index pour les performances
CREATE INDEX idx_users_xp ON users(xp DESC);
CREATE INDEX idx_users_level ON users(level DESC);
CREATE INDEX idx_likes_content ON likes(content_type, content_id);
CREATE INDEX idx_comments_content ON comments(content_type, content_id);
CREATE INDEX idx_ocs_search ON ocs(name, physical_description(100));
CREATE INDEX idx_universes_search ON universes(name, description(100));
CREATE INDEX idx_races_search ON races(name, description(100));