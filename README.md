# login-register
ในหน้าสมัครสมาชิก 
- register.php
- register_db.php
การทำงาน
register.php จะรับค่าจาก user เพื่อมาทำงานเบื้องหลังในหน้า register_db.php

ซึ่ง register_db.php
จะตรวจสอบ
- ค่าที่กรอกถูกต้องหรือไม่
- username,email ซ้ำกับในระบบหรือไม่
- ทำการแจ้งเตือนไปหน้า สมัครหากมีข้อผิดพลาดดังกล่าว

หลังจากตรวจสอบ
- hash password
- เพิ่มข้อมูลลงไปเก็บใน database
- แจ้งเตือนไปยังอีเมลผู้ใช้ที่สมัคร ผ่าน mailer *** ในส่วนตรงนี้ไม่ได้แนบโฟลเดอร์ส่งอีเมลล์มาให้ สามารถลบ หรือ comment โค้ดในส่วนนี้ได้เลย

ในหน้า login 
- login.php
- login_db.php
การทำงาน
login.php จะรับข้อมูล email และ password ไปทำงานที่เบื้องหลังในหน้า login_db.php
จะตรวจสอบ
- ค่าที่กรอกถูกต้องหรือไม่
- hash password
- email,password ถูกต้องหรือไม่โดยเทียบกับข้อมูลที่มีใน database
- หากพบจะไปสู่หน้า home
- หากผิดพลาดจะแจ้งเตือนไปถึงผู้ใช้ ว่าไม่ถูกต้อง