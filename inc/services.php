<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Content for the three service pages (SAMPLE TEXT, replace with real details).
 * Deliberately has no prices, dates, numbers or claims; unknowns say "to be confirmed".
 * Edit here and all three pages update.
 */
function vx_service_data( $slug ) {
	$venue = 'Sarvottam International School, Sector 10 Campus';
	$d = array(

		'corporate-tournament' => array(
			'name'    => 'Corporate Tournament',
			'hero'    => array( 'Play Together.<br>Win Together', 'Bring your colleagues together for friendly competition, fitness and fun on a professional cricket ground.', 'fac-nets.jpg' ),
			'overview'=> array( 'Teamwork that Plays Out on the Field', array(
				'A corporate tournament is a relaxed way for office teams to step away from the desk, play together and build real team spirit. Teams compete in organised matches while enjoying a safe, well-run cricket environment.',
				'Whether your people play cricket every week or have never held a bat, the day is built around participation, fair play and good memories.',
			), 'prog-1.jpg' ),
			'facts'   => array( 'Format' => 'Team matches', 'Venue' => $venue, 'Who can join' => 'Company and office teams', 'Schedule & fees' => 'Shared on enquiry' ),
			'why'     => array( 'What You Get', 'A Day Your Team Will Remember', array(
				array( 'Organised Matches', 'Well-planned fixtures so every team gets a fair chance to play.' ),
				array( 'Team Building', 'Colleagues work together towards a common goal, on and off the field.' ),
				array( 'Fair Play', 'A spirit-of-the-game approach that keeps the day friendly and respectful.' ),
				array( 'Fitness & Fun', 'Active time outdoors that energises people and lifts the mood.' ),
				array( 'Guidance from Coaches', 'Academy coaches on hand for tips, so even first-timers feel at ease.' ),
				array( 'A Great Experience', 'A memorable day out that brings the whole office closer.' ),
			) ),
			'steps'   => array( 'How It Works', 'From Enquiry to Match Day', array(
				array( 'Enquire', 'Tell us about your company and team size.' ),
				array( 'Register Your Team', 'Confirm your team and the tournament details with us.' ),
				array( 'Get the Schedule', 'We share the match plan and everything you need to know.' ),
				array( 'Play & Enjoy', 'Turn up, play and enjoy a great day of cricket.' ),
			) ),
			'who'     => array( 'Who Is It For?', 'Open to teams that want to play, bond and have fun together.', array( 'Corporate teams', 'Start-ups', 'Office groups', 'Company events', 'Friendly leagues' ), 'training-2.jpg' ),
			'faqs'    => array(
				array(
					array( 'Do our players need cricket experience?', 'No. The tournament is built for everyone, from regular players to complete beginners.' ),
					array( 'How many players make a team?', 'Team size and format are confirmed when you enquire, based on the tournament plan.' ),
				),
				array(
					array( 'What are the dates and fees?', 'These are shared on enquiry. Please contact us and our team will guide you.' ),
					array( 'Where is it held?', 'At ' . $venue . ', Greater Noida West, unless confirmed otherwise.' ),
				),
			),
			'cta'     => array( 'Bring Your Team to Play<i>.</i>', 'Enquire Now' ),
		),

		'workshops' => array(
			'name'    => 'Workshops',
			'hero'    => array( 'Hands-On Cricket<br>Workshops', 'Practical, focused sessions that sharpen skills, build fitness and strengthen the fundamentals of the game.', 'prog-3.jpg' ),
			'overview'=> array( 'Learn by Doing, Improve by Practising', array(
				'Our workshops are short, focused sessions where players work on specific parts of their game with proper guidance. Instead of general practice, each session has a clear goal.',
				'Players leave with simple drills they can keep using, and a better understanding of how to improve.',
			), 'prog-2.jpg' ),
			'facts'   => array( 'Format' => 'Practical group sessions', 'Venue' => $venue, 'Who can join' => 'Players of all levels', 'Schedule & fees' => 'Shared on enquiry' ),
			'why'     => array( 'What You Get', 'Skills You Can Take to the Match', array(
				array( 'Skill Drills', 'Targeted drills that build good habits through repetition.' ),
				array( 'Batting Basics', 'Stance, grip and shot selection explained in a simple way.' ),
				array( 'Bowling Technique', 'Action, rhythm and accuracy with coach feedback.' ),
				array( 'Fielding & Fitness', 'Agility, catching and conditioning for a complete game.' ),
				array( 'Small-Group Attention', 'Coaches can focus on each player, not just the group.' ),
				array( 'Clear Takeaways', 'Practical tips players can use in their own training.' ),
			) ),
			'steps'   => array( 'How It Works', 'From Sign-Up to Session', array(
				array( 'Enquire', 'Tell us who the workshop is for.' ),
				array( 'Choose a Focus', 'Pick the skills you want to work on.' ),
				array( 'Confirm Your Spot', 'We confirm the date, time and details.' ),
				array( 'Learn & Improve', 'Join the session and put it into practice.' ),
			) ),
			'who'     => array( 'Who Is It For?', 'Any player who wants to get better with proper guidance.', array( 'Beginners', 'Young cricketers', 'School teams', 'Club players', 'Parents & coaches' ), 'training-1.jpg' ),
			'faqs'    => array(
				array(
					array( 'What will the workshop cover?', 'The focus is agreed with you when you enquire, for example batting, bowling, fielding or fitness.' ),
					array( 'Do players need their own kit?', 'Please check with our team when you enquire, as requirements depend on the session.' ),
				),
				array(
					array( 'How long is a workshop?', 'Duration and timings are shared on enquiry.' ),
					array( 'What is the cost?', 'Fees are shared on enquiry. Please contact us and our team will guide you.' ),
				),
			),
			'cta'     => array( 'Book a Workshop and<br>Level Up Your Game<i>.</i>', 'Enquire Now' ),
		),

		'guest-lectures' => array(
			'name'    => 'Guest Lectures',
			'hero'    => array( 'Stories that<br>Inspire Players', 'Hear from people who know the game and take away ideas that stay with you long after the session.', 'prog-2.jpg' ),
			'overview'=> array( 'Stories and Lessons from the Game', array(
				'Guest lectures bring cricket experience into the room. Speakers share their journey, the habits that helped them and what it takes to keep going when things get tough.',
				'Each session leaves time for questions, so players, students and parents can ask what they really want to know.',
			), 'fac-run.jpg' ),
			'facts'   => array( 'Format' => 'Talk and Q&A session', 'Audience' => 'Students, players and parents', 'Venue' => 'To be confirmed', 'Schedule & booking' => 'Shared on enquiry' ),
			'why'     => array( 'What You Get', 'Inspiration with a Purpose', array(
				array( 'Real Cricket Stories', 'First-hand experiences from the world of cricket.' ),
				array( 'Career Guidance', 'An honest look at the path from the ground to higher levels.' ),
				array( 'Mental Strength', 'Handling pressure, setbacks and confidence.' ),
				array( 'Discipline & Habits', 'The daily routines that make a difference over time.' ),
				array( 'Open Q&A', 'Time to ask questions and get straight answers.' ),
				array( 'Motivation', 'Fresh energy and direction for young players.' ),
			) ),
			'steps'   => array( 'How It Works', 'From Idea to Lecture', array(
				array( 'Enquire', 'Tell us about your school, club or group.' ),
				array( 'Pick a Topic', 'Choose what you would like the talk to cover.' ),
				array( 'Fix the Date', 'We agree the date, time and venue together.' ),
				array( 'Attend & Ask', 'Listen, learn and ask your questions.' ),
			) ),
			'who'     => array( 'Who Is It For?', 'Anyone who wants to learn from cricket experience.', array( 'Schools', 'Students', 'Young players', 'Parents', 'Cricket clubs' ), 'about-wide.jpg' ),
			'faqs'    => array(
				array(
					array( 'Who gives the lectures?', 'Speakers are confirmed when you enquire, based on the topic and the date.' ),
					array( 'Can we choose the topic?', 'Yes, we plan the topic with you so that it suits your audience.' ),
				),
				array(
					array( 'How long is a lecture?', 'Duration and format are shared on enquiry.' ),
					array( 'What does it cost?', 'Details are shared on enquiry. Please contact us and our team will guide you.' ),
				),
			),
			'cta'     => array( 'Invite a Guest Speaker<br>to Your Group<i>.</i>', 'Enquire Now' ),
		),
	);
	return isset( $d[ $slug ] ) ? $d[ $slug ] : null;
}
