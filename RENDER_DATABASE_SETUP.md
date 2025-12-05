# 🗄️ Render Database Setup Guide

## Step 1: Create Database in Render

1. Go to **Render Dashboard**: https://dashboard.render.com
2. Click **"New +"** button (top right)
3. Select **"PostgreSQL"** or **"MySQL"**

### For PostgreSQL (Recommended - Free tier available):
- **Name:** `sooqlink-db`
- **Database:** `sooqlink`
- **User:** `sooqlink_user`
- **Region:** Choose closest to your users
- **Plan:** Free (or paid for better performance)
- Click **"Create Database"**

### For MySQL:
- **Name:** `sooqlink-db`
- **Database:** `sooqlink`
- **User:** `sooqlink_user`
- **Region:** Choose closest to your users
- **Plan:** Free (or paid for better performance)
- Click **"Create Database"**

---

## Step 2: Find Database Credentials

After creating the database:

1. Click on your database name (`sooqlink-db`)
2. You'll see a page with database info
3. Look for **"Connection"** or **"Connections"** section

### You'll see either:

**Option A: Internal Database URL (PostgreSQL)**
```
postgresql://sooqlink_user:password@dpg-xxxxx-a.render.com:5432/sooqlink
```

**Option B: Individual Values**
- **Host:** `dpg-xxxxx-a.render.com`
- **Port:** `5432` (PostgreSQL) or `3306` (MySQL)
- **Database:** `sooqlink`
- **Username:** `sooqlink_user`
- **Password:** `[shown here]`

---

## Step 3: Add to Environment Variables

Go to your **Web Service** → **Environment** tab and add:

### If using PostgreSQL:
```
DB_CONNECTION=pgsql
DB_HOST=dpg-xxxxx-a.render.com
DB_PORT=5432
DB_DATABASE=sooqlink
DB_USERNAME=sooqlink_user
DB_PASSWORD=[password from Render]
```

### If using MySQL:
```
DB_CONNECTION=mysql
DB_HOST=[host from Render]
DB_PORT=3306
DB_DATABASE=sooqlink
DB_USERNAME=[username from Render]
DB_PASSWORD=[password from Render]
```

---

## Step 4: Connect Database to Web Service

1. Go to your **Web Service** settings
2. Look for **"Connections"** or **"Linked Services"** section
3. Click **"Link Database"** or **"Connect"**
4. Select your `sooqlink-db` database
5. Render will automatically add environment variables!

---

## 🆘 Troubleshooting

**Can't see database?**
- Make sure you're logged into Render
- Check if database is still creating (wait 2-3 minutes)

**Can't find credentials?**
- Click on database name
- Scroll down to "Connection" section
- Click "Show" next to password

**Database connection fails?**
- Use **Internal Database URL** (faster, free)
- Make sure web service and database are in same region
- Check that environment variables are saved correctly

