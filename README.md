# Advanced Job Portal Application

A comprehensive job portal application with a Laravel backend API and React Native mobile frontend. This application enables job seekers to find and apply for jobs, while allowing employers to post job listings and manage applicants.

## Project Structure

This project consists of two main components:

1. **Backend API** (`job-portal/`): A Laravel-based RESTful API that handles data storage, authentication, and business logic.
2. **Mobile Frontend** (`job_portal_frontend/`): A cross-platform React Native mobile application built with Expo.

## Backend (Laravel API)

### Features

- RESTful API architecture
- JWT authentication with role-based access control
- Candidate and Organization user roles
- Job posting management
- Application tracking system
- Profile management
- Real-time notifications
- Database migrations and seeders

### Requirements

- PHP 8.1+
- Composer
- MySQL or SQLite
- Node.js and NPM (for frontend assets)

### Installation

1. Navigate to the backend folder:
   ```powershell
   cd "N:\disk e\books\all semm\6(Sixth-Project)\Project\6th-sem-project-advanced-job-portal\job-portal"
   ```

2. Install PHP dependencies:
   ```powershell
   composer install
   ```

3. Create a copy of the environment file:
   ```powershell
   copy .env.example .env
   ```

4. Generate an application key:
   ```powershell
   php artisan key:generate
   ```

5. Configure database settings in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=job_portal
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   For SQLite, use:
   ```
   DB_CONNECTION=sqlite
   ```
   And create an empty database file:
   ```powershell
   New-Item -ItemType File -Path "database\database.sqlite" -Force
   ```

6. Run database migrations and seeders:
   ```powershell
   php artisan migrate --seed
   ```

7. Generate JWT secret key:
   ```powershell
   php artisan jwt:secret
   ```

### Running the API Server

To run the API server for local development:
```powershell
php artisan serve
```

To make the API accessible from other devices on the same network (like your mobile device):
```powershell
php artisan serve --host 0.0.0.0 --port 8000
```

Your API will be available at `http://YOUR_LOCAL_IP:8000`. Replace `YOUR_LOCAL_IP` with your computer's IP address on the local network.

### API Routes

The API documentation can be accessed at `http://YOUR_LOCAL_IP:8000/api/documentation` when the server is running.

## Mobile Frontend (React Native with Expo)

### Features

#### For Candidates
- Browse and search job listings with filters
- View detailed job information
- Apply for jobs with a single click
- Track application status in real-time
- Manage comprehensive profile information and upload profile picture
- Resume/CV management

#### For Organizations
- Post new job listings with detailed descriptions
- Edit existing job postings
- Delete job postings
- View and manage candidate applications
- Update application statuses
- Comprehensive organization profile management with logo upload

#### Core Functionality
- Role-based authentication (Candidate/Organization)
- Role switching for users with both candidate and organization accounts
- Persistent authentication with AsyncStorage
- Real-time updates for job and application status
- Responsive UI for both Android and iOS
- Deep linking support for sharing jobs and applications
- Push notification system for application status updates

### Requirements

- Node.js 16+
- npm or yarn
- Expo CLI
- Android Studio (for Android development)
- Xcode (for iOS development, macOS only)
- Physical or virtual mobile device for testing

### Installation

1. Navigate to the frontend folder:
   ```powershell
   cd "N:\disk e\books\all semm\6(Sixth-Project)\Project\6th-sem-project-advanced-job-portal\job_portal_frontend"
   ```

2. Install dependencies:
   ```powershell
   npm install
   ```
   or
   ```powershell
   yarn
   ```

3. Create a `.env` file in the root directory and add the API URL:
   ```
   API_URL=http://YOUR_LOCAL_IP:8000/api
   ```
   Replace `YOUR_LOCAL_IP` with your computer's IP address on the local network.

4. Update the API endpoint in `src/api/auth.js`, `src/api/candidate.js`, and `src/api/organization.js` to match your backend server address.

### Running the Application for Development

1. Start the Expo development server:
   ```powershell
   npx expo start
   ```

2. You can run the app on:
   - Android Emulator: Press `a` in the terminal
   - iOS Simulator (macOS only): Press `i` in the terminal
   - Web browser: Press `w` in the terminal
   - Physical device: Scan QR code using Expo Go app

### Project Architecture

- `app/` - All screens using Expo Router file-based navigation
- `src/api/` - API services for backend communication
- `src/redux/` - Redux store, slices, and actions
- `src/theme/` - Theme configuration for consistent styling
- `src/utils/` - Utility functions for notifications, deep linking, etc.
- `src/components/` - Reusable components used across the app
- `assets/` - Images and fonts

### Deep Linking

The app supports deep linking with the custom scheme `jobportal://`. This enables features like:

- Direct navigation to specific jobs: `jobportal://jobs/123`
- Direct navigation to applications: `jobportal://applications/456`
- Sharing job listings via social media or messaging apps
- Opening the app from notifications

### Push Notifications

The app includes a push notification system that alerts users about:

- New job matches for candidates
- Application status changes
- Interview invitations
- New applications for posted jobs (organizations)
- Messages from organizations/candidates

## Building and Publishing the Application

### Building for Android

#### Prerequisites
- Android Studio installed
- JDK 11 or newer
- Android SDK installed
- Expo CLI installed

#### Steps to Generate APK

1. Install EAS CLI:
   ```powershell
   npm install -g eas-cli
   ```

2. Log in to your Expo account:
   ```powershell
   eas login
   ```

3. Configure the build:
   ```powershell
   eas build:configure
   ```

4. Create `eas.json` configuration file (if not created automatically):
   ```json
   {
     "build": {
       "development": {
         "developmentClient": true,
         "distribution": "internal"
       },
       "preview": {
         "distribution": "internal"
       },
       "production": {}
     }
   }
   ```

5. Build an Android APK (internally distributable):
   ```powershell
   eas build -p android --profile preview
   ```

6. Once the build is complete, you can download the APK from the URL provided in the terminal or from your Expo dashboard.

#### Publishing to Google Play Store

1. Create a Google Play Developer account ($25 one-time fee)

2. Configure your app for production:
   ```powershell
   eas build:configure
   ```

3. Build for production:
   ```powershell
   eas build --platform android --profile production
   ```

4. Submit to Google Play Store:
   ```powershell
   eas submit -p android
   ```

### Building for iOS

#### Prerequisites
- macOS computer
- Xcode installed
- Apple Developer account 
- Expo CLI installed

#### Steps to Generate iOS Build

1. Install EAS CLI:
   ```bash
   npm install -g eas-cli
   ```

2. Log in to your Expo account:
   ```bash
   eas login
   ```

3. Configure the build:
   ```bash
   eas build:configure
   ```

4. Build for iOS:
   ```bash
   eas build -p ios --profile preview
   ```

5. For TestFlight internal testing:
   ```bash
   eas build -p ios --profile preview --auto-submit
   ```

#### Publishing to App Store

1. Create an Apple Developer account ($99/year)

2. Configure your app for production:
   ```bash
   eas build:configure
   ```

3. Build for production:
   ```bash
   eas build --platform ios --profile production
   ```

4. Submit to App Store:
   ```bash
   eas submit -p ios
   ```

## Testing on Physical Devices

### Testing on Android

1. Enable Developer Options and USB Debugging on your Android device

2. Connect your device to your computer via USB

3. Make sure your device is recognized:
   ```powershell
   adb devices
   ```

4. Run the app on your connected device:
   ```powershell
   npx expo run:android
   ```

### Testing on iOS (requires macOS)

1. Connect your iOS device to your Mac

2. Make sure you have a valid developer certificate

3. Run the app on your connected device:
   ```bash
   npx expo run:ios --device
   ```

### Testing on Same Network (without USB)

1. Make sure your backend server is running with network access:
   ```powershell
   cd "N:\disk e\books\all semm\6(Sixth-Project)\Project\6th-sem-project-advanced-job-portal\job-portal"
   php artisan serve --host 0.0.0.0 --port 8000
   ```

2. Find your computer's IP address:
   ```powershell
   ipconfig
   ```

3. Update the API URL in the mobile app configuration to use this IP

4. Start the Expo development server:
   ```powershell
   cd "N:\disk e\books\all semm\6(Sixth-Project)\Project\6th-sem-project-advanced-job-portal\job_portal_frontend"
   npx expo start
   ```

5. Install Expo Go app on your physical device

6. Scan the QR code from the terminal using the Expo Go app (Android) or Camera app (iOS)

## Troubleshooting

### Backend API Issues

1. **Database connection error**: 
   - Verify database credentials in `.env`
   - Ensure database server is running
   - Check for proper permissions

2. **API routes not found**:
   - Run `php artisan route:list` to verify routes are registered
   - Check for proper API prefixes

3. **CORS issues**:
   - Verify CORS configuration in `config/cors.php`

### Mobile App Issues

1. **Cannot connect to API**:
   - Ensure backend server is running and accessible
   - Verify API URL is correct in configuration files
   - Check network connectivity between device and server

2. **Build errors**:
   - Run `npx expo doctor` to identify issues
   - Update Expo SDK and dependencies if needed

3. **Expo errors**:
   - Clear cache: `expo r -c`
   - Restart Expo server and development client

## License

This project is licensed under the MIT License - see the LICENSE file for details.