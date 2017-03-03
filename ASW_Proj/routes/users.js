const express  = require('express');
const router   = express.Router();
const passport = require('passport');
const jwt      = require('jsonwebtoken');
const config   = require('../config/database');
const User     = require('../models/user');

// Register
router.post("/register", (req, res, next) => {
	let newUser = new User({
		fName    : req.body.fName,
		lName    : req.body.lName,
		username : req.body.username,
		email    : req.body.email,
		password : req.body.password,
		sex      : req.body.sex,
		birthDate: req.body.birthDate,
		country  : req.body.country,
		county   : req.body.county,
		district : req.body.district,
		avatar   : req.body.avatar
	});

	User.addUser(newUser, (err, user) => {
		if(err) { 
			res.json({success: false, msg: "Failed to register user"});
		}else{
			res.json({success: true, msg: "User registered successfully"});
		}
	});
});

// Authenticate
router.post("/authenticate", (req, res, next) => {
	const username = req.body.username;
	const password = req.body.password;

	User.getUserByUsername(username, (err, user) => {
		if(err) throw err;
		if(!user){
			return res.json({success: false, msg: "User not found"});
		}else{
			User.comparePassword(password, user.password, (err, isMatch) => {
				if(err) throw err;
				if(isMatch){
					const token = [jwt.sign(user, config.secret, {
						expiresIn: 604800 // One Week
					})];
					res.json({
						success: true, 
						token  : 'JWT '+token,
						user   : {
							id      : user._id,
							name    : user.name,
							username: user.username,
							email   : user.email
						}
					});
				}else{
					return res.json({success: false, msg: "Wrong password"});
				}
			});
		}
	});
});

// Profile
router.get("/profile", passport.authenticate('jwt', {session: false}), (req, res, next) => {
	res.json({user: req.user});
});

module.exports = router;