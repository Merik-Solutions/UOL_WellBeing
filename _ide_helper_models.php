<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string|null $image
 * @property string|null $remember_token
 * @property string|null $deleted_at
 * @mixin IdeHelperAdmin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdminNotification
 *
 * @property string $title_ar
 * @property string $title_en
 * @property string $body_en
 * @property string $body_ar
 * @property string $file_url
 * @property bool $user_types
 * @property array $doctors
 * @property array $users
 * @property int $id
 * @property string|null $title
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereDoctors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereUserTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereUsers($value)
 * @mixin \Eloquent
 * @mixin IdeHelperAdminNotification
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereFileUrl($value)
 */
	class AdminNotification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BankAccount
 *
 * @property int $id
 * @property string $owner_type
 * @property int $owner_id
 * @property string $title
 * @property string $bank_name
 * @property string $iban
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $data
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $owner
 * @method static \Database\Factories\BankAccountFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereUpdatedAt($value)
 */
	class BankAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string|null $name_ar
 * @property string|null $name_en
 * @property string|null $image
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Doctor[] $doctors
 * @property-read int|null $doctors_count
 * @property-read mixed $address
 * @property-read mixed $body
 * @property-read mixed $description
 * @property-read mixed $label
 * @property-read mixed $name
 * @property-read mixed $slug
 * @property-read mixed $title
 * @mixin IdeHelperCategory
 * @property-read mixed $heal_cases
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category healCases(?string $description = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category ofDescription(?string $description = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category ofName(?string $name = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category ofTitle(?string $title = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Chat
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Doctor $doctor
 * @property-read \App\Models\Message $last_message
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\User $user
 * @mixin IdeHelperChat
 * @property int|null $patient_id
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Patient|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder|Chat lastMessage()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat lastMessageId()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat ofDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat ofPatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat unreadCount()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat withAvailableToSend()
 */
	class Chat extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\ComplaintOrFeedback
 *
 * @property int $id
 * @property int $patient_id
 * @property int|null $doctor_id
 * @property int|null $disputed_id
 * @property string|null $type
 * @property string $description
 * @property string|null $remarks
 * @property int|null $remarks_by
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $disputed_type
 * @property-read \App\Models\Doctor|null $doctor
 * @property-read \App\Models\UserDoctorPackage|null $messagePackage
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\Admin|null $remarksBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ComplaintRemarks> $remarks_history
 * @property-read int|null $remarks_history_count
 * @property-read \App\Models\Reservation|null $reservation
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback whereDisputedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback whereDisputedType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback whereRemarksBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintOrFeedback whereUpdatedAt($value)
 */
	class ComplaintOrFeedback extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ComplaintRemarks
 *
 * @property int $id
 * @property int $complaint_id
 * @property string $remarks
 * @property int $remarks_by
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ComplaintOrFeedback|null $complaint
 * @property-read \App\Models\Admin|null $remarksBy
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintRemarks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintRemarks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintRemarks query()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintRemarks whereComplaintId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintRemarks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintRemarks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintRemarks whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintRemarks whereRemarksBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintRemarks whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintRemarks whereUpdatedAt($value)
 */
	class ComplaintRemarks extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Contact
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $model_type
 * @property int|null $model_id
 * @property string|null $subject
 * @property string|null $message
 * @property string|null $image
 * @property string|null $seen_at
 * @property int|null $seen_by
 * @property string|null $reply
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Admin|null $admin
 * @mixin IdeHelperContact
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereReply($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSeenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSeenBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 */
	class Contact extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property string $code
 * @property string $flag
 * @property string $iso
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $address
 * @property-read mixed $body
 * @property-read mixed $description
 * @property-read mixed $label
 * @property-read mixed $name
 * @property-read mixed $slug
 * @property-read mixed $title
 * @mixin IdeHelperCountry
 * @property-read mixed $heal_cases
 * @method static \Illuminate\Database\Eloquent\Builder|Country healCases(?string $description = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country ofDescription(?string $description = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country ofName(?string $name = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country ofTitle(?string $title = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereIso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 */
	class Country extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Device
 *
 * @property int $id
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string $user_agent
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $notifiable
 * @mixin IdeHelperDevice
 * @property string|null $platform
 * @property string|null $voip
 * @method static \Illuminate\Database\Eloquent\Builder|Device for(array $ids = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device of(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Device ofAll($users = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Device ofDoctors($doctors = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Device ofPatients($patients = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Device ofUsers($users = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereVoip($value)
 */
	class Device extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DisabledPackage
 *
 * @property int $id
 * @property int $package_id
 * @property int $doctor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Doctor $doctor
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Package|null $package
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledPackage whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledPackage wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledPackage whereUpdatedAt($value)
 */
	class DisabledPackage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Doctor
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $title_ar
 * @property string|null $title_en
 * @property string|null $description_ar
 * @property string|null $description_en
 * @property string|null $email
 * @property string|null $password
 * @property string $phone
 * @property string|null $new_phone
 * @property string|null $code
 * @property string|null $expirence
 * @property int|null $category_id
 * @property string|null $confirmed_at
 * @property int|null $status
 * @property array|null $heal_cases
 * @property float|null $price
 * @property int|null $period
 * @property int|null $verification_code
 * @property string|null $remember_token
 * @property int $gender
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chat[] $chats
 * @property-read int|null $chats_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $fcm_token
 * @property-read int|null $fcm_token_count
 * @property-read mixed $address
 * @property-read mixed $available_day
 * @property-read mixed $available_on
 * @property-read mixed $available_time
 * @property-read mixed $body
 * @property-read mixed $description
 * @property-read mixed $label
 * @property-read mixed $slug
 * @property-read mixed $title
 * @property-read mixed $weakly_schedules
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Package[] $packages
 * @property-read int|null $packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rating[] $ratings
 * @property-read int|null $ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reservation[] $reservation
 * @property-read int|null $reservation_count
 * @property-read \App\Models\Concerns\Collections\ScheduleCollection|\App\Models\Schedule[] $schedules
 * @property-read int|null $schedules_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\VerficationCode[] $verficationCodes
 * @property-read int|null $verfication_codes_count
 * @mixin IdeHelperDoctor
 * @property string|null $name_en
 * @property string $name_ar
 * @property int|null $country_id
 * @property string $national_id
 * @property array|null $heal_cases_ar
 * @property array|null $heal_cases_en
 * @property string|null $signature
 * @property string|null $company_name
 * @property string|null $company_license
 * @property string|null $license_number
 * @property int $isPackageActive
 * @property string|null $birthdate
 * @property string|null $locale
 * @property-read \App\Models\BankAccount|null $bank_account
 * @property-read \App\Models\BankAccount|null $banks
 * @property-read \App\Models\Country|null $country
 * @property-read mixed $locale_name
 * @property-read \App\Models\UserDoctorPackage|null $packagePayable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserDoctorPackage> $paidPackages
 * @property-read int|null $paid_packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reservation> $paidReservations
 * @property-read int|null $paid_reservations_count
 * @property-read \App\Models\UserDoctorPackage|null $penalizePackagePayable
 * @property-read \App\Models\Reservation|null $penalizeReservationPayable
 * @property-read \App\Models\Reservation|null $reservationPayable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserDoctorPackage> $userDoctorPackage
 * @property-read int|null $user_doctor_package_count
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor creationType($type)
 * @method static \Database\Factories\DoctorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor hasRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor healCases(?string $description = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor isPending()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor ofBetweenTime($from = null, $to = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor ofCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor ofChat($chat_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor ofDescription(?string $description = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor ofName(?string $name = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor ofTitle(?string $title = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereCompanyLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereExpirence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereHealCasesAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereHealCasesEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereIsPackageActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereLicenseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereNewPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereVerificationCode($value)
 */
	class Doctor extends \Eloquent implements \PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject {}
}

namespace App\Models{
/**
 * App\Models\DoctorPackage
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $package_id
 * @property float $price
 * @property int $expires_in
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Doctor $doctor
 * @property-read \App\Models\Package $package
 * @mixin IdeHelperDoctorPackage
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorPackage ofDoctor($doctor_id)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorPackage ofPackage($package_id)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorPackage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorPackage whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorPackage whereExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorPackage wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorPackage wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorPackage whereUpdatedAt($value)
 */
	class DoctorPackage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Message
 *
 * @property int $id
 * @property int $chat_id
 * @property string|null $message
 * @property string $sender_type
 * @property int $sender_id
 * @property \Illuminate\Support\Carbon|null $seen_at
 * @property int|null $user_doctor_packages_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Chat $chat
 * @property-read \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\BelongsTo $receiver
 * @property-read bool $user_is_the_sender
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read Model|\Eloquent $sender
 * @mixin IdeHelperMessage
 * @property int|null $seen_by
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereSeenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereSeenBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereSenderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUserDoctorPackagesId($value)
 */
	class Message extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Note
 *
 * @property $user_id
 * @property $doctor_id
 * @property $title
 * @property $description
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Doctor $doctor
 * @property-read \App\Models\User $user
 * @mixin IdeHelperNote
 * @property int|null $patient_id
 * @property string|null $allergy
 * @property string|null $diagnosis
 * @property-read \App\Models\Patient|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder|Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note ofDoctor($doctor_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Note ofPatient($patient_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Note ofUser($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Note query()
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereAllergy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUserId($value)
 */
	class Note extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Package
 *
 * @property string $name_ar
 * @property string $name_en
 * @property string $description_ar
 * @property string $description_en
 * @property string $doc_description_ar
 * @property string $doc_description_en
 * @property double $min_price
 * @property double $max_price
 * @property int $min_expire_in
 * @property int $max_expire_in
 * @property double $quantity
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Doctor[] $doctors
 * @property-read int|null $doctors_count
 * @property-read mixed $address
 * @property-read mixed $body
 * @property-read mixed $description
 * @property-read mixed $label
 * @property-read mixed $name
 * @property-read mixed $slug
 * @property-read mixed $title
 * @mixin IdeHelperPackage
 * @property int $isActive
 * @property int $expire_in
 * @property-read mixed $heal_cases
 * @method static \Illuminate\Database\Eloquent\Builder|Package healCases(?string $description = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package ofDescription(?string $description = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Package ofName(?string $name = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Package ofTitle(?string $title = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDocDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDocDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereExpireIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereMaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereMinPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereUpdatedAt($value)
 */
	class Package extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Patient
 *
 * @property int $id
 * @property int $user_id
 * @property string $national_id
 * @property string|null $name
 * @property string|null $name_ar
 * @property string $relation
 * @property string|null $email
 * @property string|null $birthdate
 * @property string|null $image
 * @property int|null $gender
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $medical_history
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUserId($value)
 */
	class Patient extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PrescripionItem
 *
 * @property int $id
 * @property int $prescription_id
 * @property string $name
 * @property string|null $dose
 * @property string|null $dose_number
 * @property string|null $days
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PrescripionItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrescripionItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrescripionItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|PrescripionItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrescripionItem whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrescripionItem whereDose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrescripionItem whereDoseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrescripionItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrescripionItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrescripionItem wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrescripionItem whereUpdatedAt($value)
 */
	class PrescripionItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Prescription
 *
 * @property int $id
 * @property int $reservation_id
 * @property int $doctor_id
 * @property int $user_id
 * @property string|null $code
 * @property string|null $diagnosis
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @mixin IdeHelperPrescription
 * @property int|null $patient_id
 * @property string|null $title
 * @property-read \App\Models\Doctor $doctor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PrescripionItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription ofDoctor($doctor_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription ofPatient($patient_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription ofReservation($reservation_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription ofUser($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription query()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereUserId($value)
 */
	class Prescription extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Promocode
 *
 * @property string $code
 * @property string $type
 * @property string  $expired_at
 * @property integer $use_time
 * @property double $percent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserDoctorPackage[] $packages
 * @property-read int|null $packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reservation[] $reservations
 * @property-read int|null $reservations_count
 * @mixin IdeHelperPromocode
 * @method static \Database\Factories\PromocodeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode forPackages()
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode forReservation()
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode query()
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode whereUseTime($value)
 */
	class Promocode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Rating
 *
 * @property int $id
 * @property int $rate
 * @property int|null $reservation_id
 * @property int $doctor_id
 * @property int $user_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Doctor $doctor
 * @property-read \App\Models\Reservation|null $reservation
 * @property-read \App\Models\User $user
 * @mixin IdeHelperRating
 * @property int|null $patient_id
 * @property-read \App\Models\Patient|null $patient
 * @method static \Database\Factories\RatingFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating ofDoctor($doctor_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereUserId($value)
 */
	class Rating extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RefundRequest
 *
 * @property int $id
 * @property string $refundable_type
 * @property int $refundable_id
 * @property int $transaction_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $refundable
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|RefundRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundRequest whereRefundableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundRequest whereRefundableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundRequest whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundRequest whereUpdatedAt($value)
 */
	class RefundRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Reservation
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $user_id
 * @property int|null $transaction_id
 * @property int $schedule_id
 * @property int|null $promocode_id
 * @property string $price
 * @property string $date
 * @property string $from_time
 * @property string $to_time
 * @property string|null $canceled_at
 * @property string|null $status
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Transaction|null $bill
 * @property-read \App\Models\Chat|null $chat
 * @property-read \App\Models\Doctor $doctor
 * @property-read CarbonImmutable $from_date
 * @property-read mixed $start_in
 * @property-read CarbonImmutable $to_date
 * @property-read \App\Models\ReservationRequest|null $pending_request
 * @property-read \App\Models\Prescription $prescription
 * @property-read \App\Models\Rating|null $rating
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReservationRequest[] $requests
 * @property-read int|null $requests_count
 * @property-read \App\Models\Schedule $schedule
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \App\Models\User $user
 * @mixin IdeHelperReservation
 * @property int|null $patient_id
 * @property int|null $penalty_percent
 * @property int|null $price_before_penalty
 * @property int|null $invoice_id
 * @property string $wallet
 * @property int $isPaid
 * @property string $reservation_status
 * @property string $online
 * @property int|null $withdraw_id
 * @property-read \App\Models\Patient|null $Patient
 * @property-read int|null $bill_count
 * @property-read \App\Models\ComplaintOrFeedback|null $complaint_feedback
 * @property-read mixed $amount
 * @property-read int|float $commission
 * @property-read float $percentage
 * @property-read mixed $total
 * @property-read \App\Models\Transaction|null $online_transaction
 * @property-read \App\Models\Promocode|null $promocode
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserDoctorCallLog> $reservationCallLog
 * @property-read int|null $reservation_call_log_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VideoCallRecord> $videoCallRecord
 * @property-read int|null $video_call_record_count
 * @property-read \App\Models\WithdrawRequest|null $withDraw
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation creationType($type)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation ofDoctor(?int $doctor_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation ofPatient($patient_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation ofUser(?int $user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation previous()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation upComing()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereCanceledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereFromTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation wherePenaltyPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation wherePriceBeforePenalty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation wherePromocodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereReservationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereToTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereWallet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereWithdrawId($value)
 */
	class Reservation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReservationRequest
 *
 * @property int $id
 * @property int $reservation_id
 * @property string $date
 * @property string $from_time
 * @property string $to_time
 * @property string $status
 * @property string|null $changed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Reservation $reservation
 * @mixin IdeHelperReservationRequest
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereChangedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereFromTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereToTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereUpdatedAt($value)
 */
	class ReservationRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Schedule
 *
 * @property int $id
 * @property int $doctor_id
 * @property int|null $day
 * @property string|null $from_time
 * @property string|null $to_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Doctor $doctor
 * @property-read mixed $appointments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reservation[] $reservations
 * @property-read int|null $reservations_count
 * @mixin IdeHelperSchedule
 * @method static \App\Models\Concerns\Collections\ScheduleCollection<int, static> all($columns = ['*'])
 * @method static \App\Models\Concerns\Collections\ScheduleCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule ofDateInPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule ofDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule ofDoctor($doctor_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereFromTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereToTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereUpdatedAt($value)
 */
	class Schedule extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $name
 * @property string $slug_ar
 * @property string $slug_en
 * @property string $value
 * @property int $input_type
 * @property int $category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $address
 * @property-read mixed $body
 * @property-read mixed $description
 * @property-read mixed $label
 * @property-read mixed $slug
 * @property-read mixed $title
 * @mixin IdeHelperSetting
 * @property-read mixed $heal_cases
 * @method static \Illuminate\Database\Eloquent\Builder|Setting healCases(?string $description = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting ofDescription(?string $description = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting ofName(?string $name = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting ofTitle(?string $title = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereInputType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSlugAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSlugEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string|null $billable_type
 * @property int|null $billable_id
 * @property string|null $sender_type
 * @property int|null $sender_id
 * @property string|null $receiver_type
 * @property int|null $receiver_id
 * @property string $gateway
 * @property string $amount
 * @property string|null $total
 * @property string|null $commission
 * @property string|null $vat_tax
 * @property string|null $currency
 * @property string|null $gateway_id
 * @property string|null $description
 * @property float|null $previous_amount
 * @property mixed $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Model|\Eloquent $billable
 * @property-read Model|\Eloquent $receiver
 * @property-read Model|\Eloquent $sender
 * @mixin IdeHelperTransaction
 * @property string|null $invoice_id
 * @property array|null $gateway_data
 * @property string|null $status
 * @property string|null $refund_id
 * @property-read string|null $client_secret
 * @property-read bool $has_session
 * @property-read mixed $online_gateway_info
 * @property-read mixed $online_payment_id
 * @property-read mixed $online_type
 * @property-read \App\Models\RefundRequest|null $refund_request
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction creationType($type)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction dueToDoctor()
 * @method static \Database\Factories\TransactionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction filters()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction forDoctors()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction forPatients()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction isWaiting()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction isfinished()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction ofReceiver($receiver_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBillableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBillableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereGatewayData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereGatewayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePreviousAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereReceiverType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereRefundId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSenderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereVatTax($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $code
 * @property string|null $new_phone
 * @property string|null $password
 * @property string|null $birthdate
 * @property string|null $image
 * @property int|null $gender
 * @property string|null $remember_token
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chat[] $chat
 * @property-read int|null $chat_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $fcm_token
 * @property-read int|null $fcm_token_count
 * @property-read mixed $verification_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\VerficationCode[] $verficationCodes
 * @property-read int|null $verfication_codes_count
 * @mixin IdeHelperUser
 * @property int|null $country_id
 * @property string|null $locale
 * @property-read \App\Models\Country|null $country
 * @property-read mixed $age
 * @property-read mixed $pname
 * @property-read mixed $wallet
 * @property-read \App\Models\Patient|null $mydata
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient> $patients
 * @property-read int|null $patients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RefundRequest> $refundRequests
 * @property-read int|null $refund_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|User creationType($type)
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNewPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withWallet()
 */
	class User extends \Eloquent implements \PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject {}
}

namespace App\Models{
/**
 * App\Models\UserDoctorCallLog
 *
 * @property int $id
 * @property int $reservation_id
 * @property string|null $date
 * @property string|null $time
 * @property string|null $initiator
 * @property int|null $initiator_id
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Doctor|null $doctor
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\Reservation $reservation
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog isDoctor()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog isPatient()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog whereInitiator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog whereInitiatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorCallLog whereUpdatedAt($value)
 */
	class UserDoctorCallLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserDoctorPackage
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $package_id
 * @property int $doctor_package_id
 * @property int $user_id
 * @property int|null $transaction_id
 * @property int|null $promocode_id
 * @property float|null $pervious_amount
 * @property string $expired_at
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Transaction|null $bill
 * @property-read \App\Models\Doctor $doctor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\Package $package
 * @property-read \App\Models\Promocode|null $promocode
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \App\Models\User $user
 * @mixin IdeHelperUserDoctorPackage
 * @property int|null $patient_id
 * @property string $wallet
 * @property string $online
 * @property string|null $value_id
 * @property string|null $invoice_id
 * @property int|null $penalty_percent
 * @property int|null $price_before_penalty
 * @property int $isPaid
 * @property string $status
 * @property int|null $withdraw_id
 * @property-read int|null $bill_count
 * @property-read \App\Models\ComplaintOrFeedback|null $complaint_feedback
 * @property-read mixed $amount
 * @property-read int|float $commission
 * @property-read float $percentage
 * @property-read mixed $total
 * @property-read \App\Models\Message|null $latestMessage
 * @property-read \App\Models\Transaction|null $online_transaction
 * @property-read \App\Models\Patient|null $patient
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $patient_messages
 * @property-read int|null $patient_messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\WithdrawRequest|null $withDraw
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage isAvailable()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage isValid()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage messageCount()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage ofChat($chat_id)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage ofDoctor($doctor_id)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage ofPatient($patient_id)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage ofUser($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereDoctorPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage wherePenaltyPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage wherePriceBeforePenalty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage wherePromocodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereValueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereWallet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoctorPackage whereWithdrawId($value)
 */
	class UserDoctorPackage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VerficationCode
 *
 * @property int $id
 * @property string $verifiable_type
 * @property int $verifiable_id
 * @property string $code
 * @property string $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Model|\Eloquent $user
 * @mixin IdeHelperVerficationCode
 * @method static \Illuminate\Database\Eloquent\Builder|VerficationCode isValid()
 * @method static \Illuminate\Database\Eloquent\Builder|VerficationCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VerficationCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VerficationCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|VerficationCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerficationCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerficationCode whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerficationCode whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerficationCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerficationCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerficationCode whereVerifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerficationCode whereVerifiableType($value)
 */
	class VerficationCode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VideoCallRecord
 *
 * @property int $id
 * @property int $reservation_id
 * @property string|null $s_id
 * @property string|null $u_id
 * @property string|null $resource_id
 * @property string|null $file_name
 * @property string|null $file_url
 * @property string|null $signature
 * @property mixed|null $file_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Reservation $reservation
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord whereFileData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord whereResourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord whereSId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord whereUId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoCallRecord whereUpdatedAt($value)
 */
	class VideoCallRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WithdrawRequest
 *
 * @property int $id
 * @property int|null $doctor_id
 * @property string $amount
 * @property string $status
 * @property string|null $answered_by
 * @property int|null $transaction_id
 * @property string $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Doctor|null $doctor
 * @property-read \App\Models\Transaction|null $transaction
 * @mixin \Eloquent
 * @mixin IdeHelperWithdrawRequest
 * @property string|null $bank_transaction_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $billable
 * @property-read int|null $billable_count
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest creationType($type)
 * @method static \Database\Factories\WithdrawRequestFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest ofDoctor($doctor_id)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereAnsweredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereBankTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereUpdatedAt($value)
 */
	class WithdrawRequest extends \Eloquent {}
}

