USE skillbridge;

-- INSERT IGNORE makes this starter data safe to import more than once.
INSERT IGNORE INTO skill_categories (category_name) VALUES
    ('Programming & Technology'),
    ('Graphic Design'),
    ('Photography'),
    ('Video Editing'),
    ('Music'),
    ('Languages'),
    ('Digital Marketing'),
    ('Business'),
    ('Public Speaking'),
    ('Microsoft Office Packages'),
    ('Cooking'),
    ('Fitness'),
    ('Art & Drawing');

INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'PHP' FROM skill_categories WHERE category_name = 'Programming & Technology';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Web Development' FROM skill_categories WHERE category_name = 'Programming & Technology';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'MySQL' FROM skill_categories WHERE category_name = 'Programming & Technology';

INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Photoshop' FROM skill_categories WHERE category_name = 'Graphic Design';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Illustrator' FROM skill_categories WHERE category_name = 'Graphic Design';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Logo Design' FROM skill_categories WHERE category_name = 'Graphic Design';

INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Photography Basics' FROM skill_categories WHERE category_name = 'Photography';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Portrait Photography' FROM skill_categories WHERE category_name = 'Photography';

INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Video Editing' FROM skill_categories WHERE category_name = 'Video Editing';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Adobe Premiere Pro' FROM skill_categories WHERE category_name = 'Video Editing';

INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Guitar' FROM skill_categories WHERE category_name = 'Music';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Piano' FROM skill_categories WHERE category_name = 'Music';

INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'English' FROM skill_categories WHERE category_name = 'Languages';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Sinhala' FROM skill_categories WHERE category_name = 'Languages';

INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Social Media Marketing' FROM skill_categories WHERE category_name = 'Digital Marketing';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'SEO Basics' FROM skill_categories WHERE category_name = 'Digital Marketing';

INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Entrepreneurship Basics' FROM skill_categories WHERE category_name = 'Business';

INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Public Speaking' FROM skill_categories WHERE category_name = 'Public Speaking';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Presentation Skills' FROM skill_categories WHERE category_name = 'Public Speaking';

INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Microsoft Excel' FROM skill_categories WHERE category_name = 'Microsoft Office Packages';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Microsoft Word' FROM skill_categories WHERE category_name = 'Microsoft Office Packages';

INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Cooking Basics' FROM skill_categories WHERE category_name = 'Cooking';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Baking Basics' FROM skill_categories WHERE category_name = 'Cooking';

INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Personal Fitness' FROM skill_categories WHERE category_name = 'Fitness';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Yoga Basics' FROM skill_categories WHERE category_name = 'Fitness';

INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Drawing Basics' FROM skill_categories WHERE category_name = 'Art & Drawing';
INSERT IGNORE INTO skills (category_id, skill_name)
SELECT category_id, 'Painting Basics' FROM skill_categories WHERE category_name = 'Art & Drawing';
