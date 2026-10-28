USE skillbridge;

-- Optional presentation data. Import after skillbridge.sql and seed.sql.
-- All people, email addresses, phone numbers, and biographies below are fictional.
-- Shared password for every demo account: SkillBridge123
SET @demo_password = '$2y$10$6zF8s2ULVMV1wtv5iuhT8OgQXRAdz2D4O5XZl8TXHGxya7puX7Cm6';

INSERT INTO users
    (first_name, last_name, email, password, phone, location, bio, role, account_status, created_at)
VALUES
    ('Malith', 'Wijesundara', 'admin.demo@skillbridge.test', @demo_password, '0705550100', 'Colombo', 'SkillBridge demonstration administrator.', 'admin', 'active', '2026-06-01 09:00:00'),
    ('Nimal', 'Perera', 'nimal.perera@skillbridge.test', @demo_password, '0705550101', 'Colombo', 'Software developer who enjoys helping beginners build practical web applications.', 'user', 'active', '2026-06-03 10:15:00'),
    ('Sachini', 'Silva', 'sachini.silva@skillbridge.test', @demo_password, '0705550102', 'Nugegoda', 'Communication trainer focused on confident English and public speaking.', 'user', 'active', '2026-06-05 14:20:00'),
    ('Kasun', 'Jayasinghe', 'kasun.jayasinghe@skillbridge.test', @demo_password, '0705550103', 'Kandy', 'Part-time music tutor teaching guitar and piano to learners of all ages.', 'user', 'active', '2026-06-08 11:30:00'),
    ('Dinithi', 'Fernando', 'dinithi.fernando@skillbridge.test', @demo_password, '0705550104', 'Galle', 'Freelance designer creating brand identities and social media artwork.', 'user', 'active', '2026-06-12 08:45:00'),
    ('Tharindu', 'Bandara', 'tharindu.bandara@skillbridge.test', @demo_password, '0705550105', 'Kurunegala', 'Full-stack web developer who teaches through small hands-on projects.', 'user', 'active', '2026-06-16 16:10:00'),
    ('Ishini', 'Wickramasinghe', 'ishini.wickramasinghe@skillbridge.test', @demo_password, '0705550106', 'Battaramulla', 'Business analyst experienced in spreadsheets, reports, and office productivity.', 'user', 'active', '2026-06-20 09:25:00'),
    ('Arjun', 'Thurairajah', 'arjun.thurairajah@skillbridge.test', @demo_password, '0705550107', 'Jaffna', 'Bilingual language mentor supporting conversational English and Sinhala practice.', 'user', 'active', '2026-06-24 13:05:00'),
    ('Nadeesha', 'Ranasinghe', 'nadeesha.ranasinghe@skillbridge.test', @demo_password, '0705550108', 'Matara', 'Home baker sharing approachable Sri Lankan cooking and baking techniques.', 'user', 'active', '2026-06-28 17:40:00'),
    ('Chamara', 'Gunawardena', 'chamara.gunawardena@skillbridge.test', @demo_password, '0705550109', 'Negombo', 'Photographer specialising in portraits, events, and natural-light techniques.', 'user', 'active', '2026-07-02 10:50:00'),
    ('Fathima', 'Rizwan', 'fathima.rizwan@skillbridge.test', @demo_password, '0705550110', 'Colombo', 'Digital marketer helping small businesses improve their online presence.', 'user', 'active', '2026-07-06 12:35:00'),
    ('Lahiru', 'Senanayake', 'lahiru.senanayake@skillbridge.test', @demo_password, '0705550111', 'Maharagama', 'Video editor with experience in short films, interviews, and online content.', 'user', 'active', '2026-07-10 15:15:00'),
    ('Piumi', 'Abeysekara', 'piumi.abeysekara@skillbridge.test', @demo_password, '0705550112', 'Kandy', 'University student interested in technology, music, and career skills.', 'user', 'active', '2026-07-14 09:10:00'),
    ('Ravindu', 'Dissanayake', 'ravindu.dissanayake@skillbridge.test', @demo_password, '0705550113', 'Gampaha', 'Fictional disabled account included to demonstrate account management.', 'user', 'disabled', '2026-07-18 11:55:00'),
    ('Kavindi', 'Madushika', 'kavindi.madushika@skillbridge.test', @demo_password, '0705550114', 'Galle', 'Recent graduate exploring design, communication, and digital skills.', 'user', 'active', '2026-07-22 14:30:00')
ON DUPLICATE KEY UPDATE
    first_name = VALUES(first_name), last_name = VALUES(last_name), password = VALUES(password),
    phone = VALUES(phone), location = VALUES(location), bio = VALUES(bio), role = VALUES(role),
    account_status = VALUES(account_status), created_at = VALUES(created_at);

-- Teaching listings. INSERT IGNORE uses the existing unique user/skill constraint.
INSERT IGNORE INTO teaching_skills (user_id, skill_id, experience_level, years_experience, description, hourly_rate, created_at)
SELECT u.user_id, s.skill_id, 'Expert', 6, 'Build PHP applications with forms, sessions, validation, and mysqli prepared statements.', 4500, '2026-07-01 10:00:00' FROM users u JOIN skills s ON s.skill_name='PHP' WHERE u.email='nimal.perera@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Advanced', 5, 'Understand relational design, joins, constraints, and practical MySQL queries.', 3000, '2026-07-02 10:00:00' FROM users u JOIN skills s ON s.skill_name='MySQL' WHERE u.email='nimal.perera@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Advanced', 4, 'Improve everyday spoken English, vocabulary, and interview confidence.', 2500, '2026-07-03 10:00:00' FROM users u JOIN skills s ON s.skill_name='English' WHERE u.email='sachini.silva@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Intermediate', 3, 'Practise speech structure, delivery, and confident presentations.', 1800, '2026-07-04 10:00:00' FROM users u JOIN skills s ON s.skill_name='Public Speaking' WHERE u.email='sachini.silva@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Intermediate', 5, 'Learn chords, rhythm patterns, and popular Sinhala and English songs.', 1700, '2026-07-05 10:00:00' FROM users u JOIN skills s ON s.skill_name='Guitar' WHERE u.email='kasun.jayasinghe@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Advanced', 8, 'Piano lessons covering reading, technique, and performance basics.', 3200, '2026-07-06 10:00:00' FROM users u JOIN skills s ON s.skill_name='Piano' WHERE u.email='kasun.jayasinghe@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Advanced', 4, 'Create polished posters and social media graphics using Photoshop.', 2800, '2026-07-07 10:00:00' FROM users u JOIN skills s ON s.skill_name='Photoshop' WHERE u.email='dinithi.fernando@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Expert', 7, 'Develop memorable logo concepts from sketch to final presentation.', 4500, '2026-07-08 10:00:00' FROM users u JOIN skills s ON s.skill_name='Logo Design' WHERE u.email='dinithi.fernando@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Expert', 8, 'Plan and build responsive websites with PHP, MySQL, HTML, CSS, and JavaScript.', 5000, '2026-07-09 10:00:00' FROM users u JOIN skills s ON s.skill_name='Web Development' WHERE u.email='tharindu.bandara@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Advanced', 5, 'Practical PHP lessons for students building database-backed projects.', 3500, '2026-07-10 10:00:00' FROM users u JOIN skills s ON s.skill_name='PHP' WHERE u.email='tharindu.bandara@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Expert', 7, 'Use Excel formulas, charts, lookups, and pivot tables for business work.', 4200, '2026-07-11 10:00:00' FROM users u JOIN skills s ON s.skill_name='Microsoft Excel' WHERE u.email='ishini.wickramasinghe@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Advanced', 6, 'Create well-formatted reports, letters, tables, and reusable Word documents.', 2500, '2026-07-12 10:00:00' FROM users u JOIN skills s ON s.skill_name='Microsoft Word' WHERE u.email='ishini.wickramasinghe@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Expert', 9, 'Conversational English practice with clear grammar and pronunciation support.', 4800, '2026-07-13 10:00:00' FROM users u JOIN skills s ON s.skill_name='English' WHERE u.email='arjun.thurairajah@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Intermediate', 4, 'Friendly Sinhala speaking practice for everyday situations.', 1500, '2026-07-14 10:00:00' FROM users u JOIN skills s ON s.skill_name='Sinhala' WHERE u.email='arjun.thurairajah@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Advanced', 6, 'Prepare reliable rice, curry, sambol, and everyday Sri Lankan meals.', 2600, '2026-07-15 10:00:00' FROM users u JOIN skills s ON s.skill_name='Cooking Basics' WHERE u.email='nadeesha.ranasinghe@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Intermediate', 3, 'Learn simple cakes, breads, measurements, and oven techniques.', 1600, '2026-07-16 10:00:00' FROM users u JOIN skills s ON s.skill_name='Baking Basics' WHERE u.email='nadeesha.ranasinghe@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Expert', 10, 'Master camera settings, composition, lighting, and practical photo exercises.', 5000, '2026-07-17 10:00:00' FROM users u JOIN skills s ON s.skill_name='Photography Basics' WHERE u.email='chamara.gunawardena@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Advanced', 7, 'Plan and shoot natural portraits using simple indoor and outdoor lighting.', 3500, '2026-07-18 10:00:00' FROM users u JOIN skills s ON s.skill_name='Portrait Photography' WHERE u.email='chamara.gunawardena@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Advanced', 5, 'Create practical content plans and campaigns for Sri Lankan small businesses.', 3000, '2026-07-19 10:00:00' FROM users u JOIN skills s ON s.skill_name='Social Media Marketing' WHERE u.email='fathima.rizwan@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Intermediate', 3, 'Learn keyword research, page optimisation, and basic search reporting.', 1800, '2026-07-20 10:00:00' FROM users u JOIN skills s ON s.skill_name='SEO Basics' WHERE u.email='fathima.rizwan@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Expert', 7, 'Edit clear, engaging videos with good pacing, audio, titles, and colour.', 4800, '2026-07-21 10:00:00' FROM users u JOIN skills s ON s.skill_name='Video Editing' WHERE u.email='lahiru.senanayake@skillbridge.test';
INSERT IGNORE INTO teaching_skills SELECT NULL, u.user_id, s.skill_id, 'Advanced', 5, 'Hands-on Premiere Pro editing for interviews, events, and online videos.', 3500, '2026-07-22 10:00:00' FROM users u JOIN skills s ON s.skill_name='Adobe Premiere Pro' WHERE u.email='lahiru.senanayake@skillbridge.test';

-- Cache the IDs used by the request and notification records.
SET @nimal=(SELECT user_id FROM users WHERE email='nimal.perera@skillbridge.test');
SET @sachini=(SELECT user_id FROM users WHERE email='sachini.silva@skillbridge.test');
SET @kasun=(SELECT user_id FROM users WHERE email='kasun.jayasinghe@skillbridge.test');
SET @dinithi=(SELECT user_id FROM users WHERE email='dinithi.fernando@skillbridge.test');
SET @tharindu=(SELECT user_id FROM users WHERE email='tharindu.bandara@skillbridge.test');
SET @ishini=(SELECT user_id FROM users WHERE email='ishini.wickramasinghe@skillbridge.test');
SET @arjun=(SELECT user_id FROM users WHERE email='arjun.thurairajah@skillbridge.test');
SET @nadeesha=(SELECT user_id FROM users WHERE email='nadeesha.ranasinghe@skillbridge.test');
SET @chamara=(SELECT user_id FROM users WHERE email='chamara.gunawardena@skillbridge.test');
SET @fathima=(SELECT user_id FROM users WHERE email='fathima.rizwan@skillbridge.test');
SET @lahiru=(SELECT user_id FROM users WHERE email='lahiru.senanayake@skillbridge.test');
SET @piumi=(SELECT user_id FROM users WHERE email='piumi.abeysekara@skillbridge.test');
SET @kavindi=(SELECT user_id FROM users WHERE email='kavindi.madushika@skillbridge.test');

SET @ts_nimal_php=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@nimal AND s.skill_name='PHP');
SET @ts_nimal_mysql=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@nimal AND s.skill_name='MySQL');
SET @ts_sachini_english=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@sachini AND s.skill_name='English');
SET @ts_sachini_speaking=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@sachini AND s.skill_name='Public Speaking');
SET @ts_kasun_guitar=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@kasun AND s.skill_name='Guitar');
SET @ts_kasun_piano=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@kasun AND s.skill_name='Piano');
SET @ts_dinithi_photoshop=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@dinithi AND s.skill_name='Photoshop');
SET @ts_dinithi_logo=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@dinithi AND s.skill_name='Logo Design');
SET @ts_tharindu_web=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@tharindu AND s.skill_name='Web Development');
SET @ts_ishini_excel=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@ishini AND s.skill_name='Microsoft Excel');
SET @ts_arjun_english=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@arjun AND s.skill_name='English');
SET @ts_nadeesha_cooking=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@nadeesha AND s.skill_name='Cooking Basics');
SET @ts_chamara_photo=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@chamara AND s.skill_name='Photography Basics');
SET @ts_fathima_social=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@fathima AND s.skill_name='Social Media Marketing');
SET @ts_lahiru_video=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@lahiru AND s.skill_name='Video Editing');
SET @ts_lahiru_premiere=(SELECT ts.teaching_skill_id FROM teaching_skills ts JOIN skills s ON ts.skill_id=s.skill_id WHERE ts.user_id=@lahiru AND s.skill_name='Adobe Premiere Pro');

-- Requests are identified by learner, listing, and message so repeat imports stay safe.
INSERT INTO learning_requests (learner_id,teacher_id,teaching_skill_id,message,status,request_date,accepted_date) SELECT @piumi,@nimal,@ts_nimal_php,'I would like help building the PHP section of my university project.','Accepted','2026-08-01 09:15:00','2026-08-01 18:30:00' WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@piumi AND teaching_skill_id=@ts_nimal_php AND message='I would like help building the PHP section of my university project.');
INSERT INTO learning_requests SELECT NULL,@kavindi,@sachini,@ts_sachini_english,'I want to improve my spoken English before job interviews.','Pending','2026-08-03 11:20:00',NULL WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@kavindi AND teaching_skill_id=@ts_sachini_english AND message='I want to improve my spoken English before job interviews.');
INSERT INTO learning_requests SELECT NULL,@nimal,@kasun,@ts_kasun_guitar,'Can you teach me basic guitar chords for Sinhala songs?','Rejected','2026-08-04 16:10:00',NULL WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@nimal AND teaching_skill_id=@ts_kasun_guitar AND message='Can you teach me basic guitar chords for Sinhala songs?');
INSERT INTO learning_requests SELECT NULL,@sachini,@dinithi,@ts_dinithi_photoshop,'I need practical Photoshop guidance for social media posters.','Accepted','2026-08-06 10:45:00','2026-08-06 15:25:00' WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@sachini AND teaching_skill_id=@ts_dinithi_photoshop AND message='I need practical Photoshop guidance for social media posters.');
INSERT INTO learning_requests SELECT NULL,@kasun,@tharindu,@ts_tharindu_web,'I would like to create a simple website for my music classes.','Pending','2026-08-08 08:35:00',NULL WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@kasun AND teaching_skill_id=@ts_tharindu_web AND message='I would like to create a simple website for my music classes.');
INSERT INTO learning_requests SELECT NULL,@dinithi,@ishini,@ts_ishini_excel,'Please help me organise freelance income and expenses in Excel.','Accepted','2026-08-10 13:40:00','2026-08-10 17:05:00' WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@dinithi AND teaching_skill_id=@ts_ishini_excel AND message='Please help me organise freelance income and expenses in Excel.');
INSERT INTO learning_requests SELECT NULL,@tharindu,@arjun,@ts_arjun_english,'I am looking for advanced English conversation practice.','Rejected','2026-08-12 19:10:00',NULL WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@tharindu AND teaching_skill_id=@ts_arjun_english AND message='I am looking for advanced English conversation practice.');
INSERT INTO learning_requests SELECT NULL,@ishini,@nadeesha,@ts_nadeesha_cooking,'I want to learn a few reliable Sri Lankan lunch recipes.','Pending','2026-08-15 09:55:00',NULL WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@ishini AND teaching_skill_id=@ts_nadeesha_cooking AND message='I want to learn a few reliable Sri Lankan lunch recipes.');
INSERT INTO learning_requests SELECT NULL,@arjun,@chamara,@ts_chamara_photo,'Can you explain manual camera settings and composition?','Accepted','2026-08-17 14:25:00','2026-08-18 09:00:00' WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@arjun AND teaching_skill_id=@ts_chamara_photo AND message='Can you explain manual camera settings and composition?');
INSERT INTO learning_requests SELECT NULL,@nadeesha,@fathima,@ts_fathima_social,'I need a simple social media plan for a home baking page.','Accepted','2026-08-20 12:15:00','2026-08-20 20:10:00' WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@nadeesha AND teaching_skill_id=@ts_fathima_social AND message='I need a simple social media plan for a home baking page.');
INSERT INTO learning_requests SELECT NULL,@chamara,@lahiru,@ts_lahiru_video,'I want to edit short highlight videos from photography sessions.','Pending','2026-08-22 15:45:00',NULL WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@chamara AND teaching_skill_id=@ts_lahiru_video AND message='I want to edit short highlight videos from photography sessions.');
INSERT INTO learning_requests SELECT NULL,@fathima,@nimal,@ts_nimal_mysql,'Could you help me understand MySQL reports for campaign data?','Rejected','2026-08-24 10:05:00',NULL WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@fathima AND teaching_skill_id=@ts_nimal_mysql AND message='Could you help me understand MySQL reports for campaign data?');
INSERT INTO learning_requests SELECT NULL,@lahiru,@sachini,@ts_sachini_speaking,'I would like to become more confident presenting video proposals.','Accepted','2026-08-26 18:20:00','2026-08-27 08:40:00' WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@lahiru AND teaching_skill_id=@ts_sachini_speaking AND message='I would like to become more confident presenting video proposals.');
INSERT INTO learning_requests SELECT NULL,@piumi,@kasun,@ts_kasun_piano,'I am a beginner and would like an introduction to piano.','Pending','2026-08-28 11:30:00',NULL WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@piumi AND teaching_skill_id=@ts_kasun_piano AND message='I am a beginner and would like an introduction to piano.');
INSERT INTO learning_requests SELECT NULL,@kavindi,@dinithi,@ts_dinithi_logo,'Can you guide me through creating a portfolio logo?','Rejected','2026-08-30 09:50:00',NULL WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@kavindi AND teaching_skill_id=@ts_dinithi_logo AND message='Can you guide me through creating a portfolio logo?');
INSERT INTO learning_requests SELECT NULL,@sachini,@lahiru,@ts_lahiru_premiere,'I need help editing and exporting a short presentation video.','Pending','2026-09-01 14:10:00',NULL WHERE NOT EXISTS (SELECT 1 FROM learning_requests WHERE learner_id=@sachini AND teaching_skill_id=@ts_lahiru_premiere AND message='I need help editing and exporting a short presentation video.');

-- Every request creates a teacher notification; final decisions notify the learner.
INSERT INTO notifications (user_id,message,is_read,created_at)
SELECT x.user_id,x.message,x.is_read,x.created_at FROM (
SELECT @nimal user_id,'You received a new learning request.' message,TRUE is_read,'2026-08-01 09:15:05' created_at UNION ALL
SELECT @sachini,'You received a new learning request.',TRUE,'2026-08-03 11:20:05' UNION ALL
SELECT @kasun,'You received a new learning request.',TRUE,'2026-08-04 16:10:05' UNION ALL
SELECT @dinithi,'You received a new learning request.',TRUE,'2026-08-06 10:45:05' UNION ALL
SELECT @tharindu,'You received a new learning request.',FALSE,'2026-08-08 08:35:05' UNION ALL
SELECT @ishini,'You received a new learning request.',TRUE,'2026-08-10 13:40:05' UNION ALL
SELECT @arjun,'You received a new learning request.',TRUE,'2026-08-12 19:10:05' UNION ALL
SELECT @nadeesha,'You received a new learning request.',FALSE,'2026-08-15 09:55:05' UNION ALL
SELECT @chamara,'You received a new learning request.',TRUE,'2026-08-17 14:25:05' UNION ALL
SELECT @fathima,'You received a new learning request.',TRUE,'2026-08-20 12:15:05' UNION ALL
SELECT @lahiru,'You received a new learning request.',FALSE,'2026-08-22 15:45:05' UNION ALL
SELECT @nimal,'You received a new learning request.',TRUE,'2026-08-24 10:05:05' UNION ALL
SELECT @sachini,'You received a new learning request.',TRUE,'2026-08-26 18:20:05' UNION ALL
SELECT @kasun,'You received a new learning request.',FALSE,'2026-08-28 11:30:05' UNION ALL
SELECT @dinithi,'You received a new learning request.',FALSE,'2026-08-30 09:50:05' UNION ALL
SELECT @lahiru,'You received a new learning request.',FALSE,'2026-09-01 14:10:05' UNION ALL
SELECT @piumi,'Your learning request was accepted.',TRUE,'2026-08-01 18:30:05' UNION ALL
SELECT @nimal,'Your learning request was rejected.',TRUE,'2026-08-04 16:45:05' UNION ALL
SELECT @sachini,'Your learning request was accepted.',TRUE,'2026-08-06 15:25:05' UNION ALL
SELECT @dinithi,'Your learning request was accepted.',TRUE,'2026-08-10 17:05:05' UNION ALL
SELECT @tharindu,'Your learning request was rejected.',TRUE,'2026-08-13 08:20:05' UNION ALL
SELECT @arjun,'Your learning request was accepted.',TRUE,'2026-08-18 09:00:05' UNION ALL
SELECT @nadeesha,'Your learning request was accepted.',FALSE,'2026-08-20 20:10:05' UNION ALL
SELECT @fathima,'Your learning request was rejected.',TRUE,'2026-08-24 19:30:05' UNION ALL
SELECT @lahiru,'Your learning request was accepted.',FALSE,'2026-08-27 08:40:05' UNION ALL
SELECT @kavindi,'Your learning request was rejected.',FALSE,'2026-08-30 17:15:05'
) x
WHERE NOT EXISTS (
    SELECT 1 FROM notifications n
    WHERE n.user_id=x.user_id AND n.message=x.message AND n.created_at=x.created_at
);
