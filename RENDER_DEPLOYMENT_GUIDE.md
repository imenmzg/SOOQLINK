# 🚀 SOOQLINK - Render Deployment Guide

## 📋 Prerequisites

Before deploying to Render, ensure you have:
- GitHub repository with all code pushed
- A Render account (free tier available at https://render.com)

## 🛠️ Step-by-Step Deployment

### 1️⃣ **Push Code to GitHub**

```bash
cd "/Users/user/Desktop/bouthaina project /SOOQLINK"

# Add all files
git add .

# Commit changes
git commit -m "Add Render deployment configuration"

# Push to GitHub
git push origin main
```

### 2️⃣ **Create Database on Render**

1. Go to https://dashboard.render.com
2. Click **"New +"** → **"PostgreSQL"** (or MySQL)
3. Fill in:
   - **Name:** `sooqlink-db`
   - **Database:** `sooqlink`
   - **User:** `sooqlink`
   - **Region:** Choose closest to your users
   - **Plan:** Free (or paid for better performance)
4. Click **"Create Database"**
5. **SAVE** the connection details (you'll need them later):
   - Internal Database URL
   - External Database URL
   - Username
   - Password

### 3️⃣ **Create Web Service on Render**

1. Click **"New +"** → **"Web Service"**
2. Connect your GitHub repository: `imenmzg/SOOQLINK`
3. Configure:
   - **Name:** `sooqlink`
   - **Region:** Same as database
   - **Branch:** `main`
   - **Root Directory:** (leave empty)
   - **Environment:** `Docker`
   - **Dockerfile Path:** `./Dockerfile`
   - **Docker Command:** (leave empty - uses Dockerfile's CMD)
   - **Plan:** Free (or paid)

### 4️⃣ **Set Environment Variables**

Click **"Advanced"** and add these environment variables:

#### Required Variables:
```
APP_NAME=SOOQLINK
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_KEY_HERE
APP_URL=https://sooqlink.onrender.com

# Database (use values from Step 2)
DB_CONNECTION=mysql
DB_HOST=your-database-host.render.com
DB_PORT=3306
DB_DATABASE=sooqlink
DB_USERNAME=sooqlink
DB_PASSWORD=your-password-here

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Mail (optional - configure later)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=noreply@sooqlink.com
MAIL_FROM_NAME=SOOQLINK
```

#### Generate APP_KEY:
```bash
# Run locally to generate a key
php artisan key:generate --show

# Copy the output (e.g., base64:abc123...)
# Paste it as APP_KEY value in Render
```

### 5️⃣ **Deploy**

1. Click **"Create Web Service"**
2. Render will automatically:
   - Clone your repository
   - Build the Docker image
   - Start the container
   - Run migrations
3. Wait 5-10 minutes for the first deployment
4. Your site will be live at: `https://sooqlink.onrender.com`

---

## 🔧 Post-Deployment Setup

### Access Admin Panel

1. Visit: `https://sooqlink.onrender.com/admin`
2. Login with your admin credentials
3. If no admin exists, create one via SSH:

```bash
# In Render Dashboard → Shell
php artisan tinker

# Then run:
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@sooqlink.com';
$user->password = bcrypt('your-secure-password');
$user->role = 'admin';
$user->save();
exit
```

### Configure File Storage

For production file uploads, use cloud storage:

1. **Update `.env` on Render:**
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=sooqlink-media
AWS_URL=https://sooqlink-media.s3.amazonaws.com
```

2. **Or use Cloudinary (simpler):**
```
FILESYSTEM_DISK=cloudinary
CLOUDINARY_URL=cloudinary://key:secret@cloud_name
```

---

## 🐛 Troubleshooting

### Build Fails

**Error:** `composer install failed`
- **Fix:** Ensure `composer.json` and `composer.lock` are committed
- Run `composer update` locally and push

**Error:** `Permission denied on storage`
- **Fix:** Already handled in `entrypoint.sh`

### Database Connection Failed

- **Check:** Environment variables are correct
- **Check:** Database is in the same region as web service
- **Use:** Internal Database URL (faster, free)

### 500 Error on Visit

1. Check logs in Render Dashboard
2. Enable debug temporarily:
   ```
   APP_DEBUG=true
   ```
3. Visit site to see detailed error
4. Fix issue and set `APP_DEBUG=false`

### Assets Not Loading

**CSS/JS 404 errors:**
```bash
# In Render Shell
php artisan storage:link
npm run build  # if using Vite
```

---

## 📊 Using Render Blueprint (Easier Method)

Instead of manual setup, you can use the `render.yaml` file:

1. In Render Dashboard, go to **"Blueprints"**
2. Click **"New Blueprint Instance"**
3. Connect your repo: `imenmzg/SOOQLINK`
4. Render will automatically detect `render.yaml`
5. Review and create services
6. Set environment variables as prompted

---

## 💰 Free Tier Limitations

Render's free tier includes:
- ✅ 750 hours/month (enough for 1 app running 24/7)
- ✅ SSL certificates
- ✅ Automatic deploys from GitHub
- ❌ Spins down after 15 minutes of inactivity (first request takes ~30s)
- ❌ 512 MB RAM (sufficient for small traffic)

**For production:** Upgrade to paid plan for:
- No spin-down
- More RAM/CPU
- Better performance
- Persistent storage

---

## 🔄 Updating Your App

Every time you push to GitHub `main` branch:
1. Render automatically rebuilds
2. Runs migrations
3. Deploys new version
4. Zero downtime deployment

---

## 📞 Support

If deployment fails:
1. Check **Logs** in Render Dashboard
2. Check **Events** tab for build errors
3. Review environment variables
4. Contact Render support (excellent free support!)

---

## ✅ Deployment Checklist

- [ ] Code pushed to GitHub
- [ ] `Dockerfile` and `render.yaml` in repo
- [ ] Database created on Render
- [ ] Web service created
- [ ] All environment variables set
- [ ] `APP_KEY` generated
- [ ] Database credentials correct
- [ ] First deployment successful
- [ ] Admin user created
- [ ] Site accessible at `https://your-app.onrender.com`
- [ ] Admin panel accessible
- [ ] File uploads working
- [ ] Translations working (AR/EN/FR)

---

## 🎉 Success!

Your SOOQLINK platform is now live on Render! 

**URL:** https://sooqlink.onrender.com

**Admin:** https://sooqlink.onrender.com/admin

**Supplier:** https://sooqlink.onrender.com/supplier

**Client:** https://sooqlink.onrender.com/client

