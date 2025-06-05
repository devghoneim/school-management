<?php

namespace App\Providers;

use App\Models\Subject;
use App\Repository\AttendanceRepository;
use App\Repository\AttendanceRepositoryInterface;
use App\Repository\FeeInvoicesRepository;
use App\Repository\FeeInvoicesRepositoryInterface;
use App\Repository\FeeRepository;
use App\Repository\FeeRepositoryInterface;
use App\Repository\GraduatedRepository;
use App\Repository\GraduatedRepositoryInterface;
use App\Repository\LibraryRepository;
use App\Repository\LibraryRepositoryInterface;
use App\Repository\ProcessingFeeRepository;
use App\Repository\ProcessingFeeRepositoryInterface;
use App\Repository\QuestionRepository;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\QuizzRepository;
use App\Repository\QuizzRepositoryInterface;
use App\Repository\ReceiptStudentsRepository;
use App\Repository\ReceiptStudentsRepositoryInterface;
use App\Repository\StudentRepository;
use App\Repository\StudentRepositoryInterface;
use App\Repository\StudentsPormotions;
use App\Repository\StudentsPormotionsInterface;
use App\Repository\SubjectRepository;
use App\Repository\SubjectRepositoryInterface;
use App\Repository\TeacherRepository;
use App\Repository\TeacherRepositoryInterface;
use Illuminate\Support\ServiceProvider;


class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TeacherRepositoryInterface::class,TeacherRepository::class);
        $this->app->bind(StudentRepositoryInterface::class,StudentRepository::class);
        $this->app->bind(StudentsPormotionsInterface::class,StudentsPormotions::class);
        $this->app->bind(GraduatedRepositoryInterface::class,GraduatedRepository::class);
        $this->app->bind(FeeRepositoryInterface::class,FeeRepository::class);
        $this->app->bind(FeeInvoicesRepositoryInterface::class,FeeInvoicesRepository::class);
        $this->app->bind(ReceiptStudentsRepositoryInterface::class,ReceiptStudentsRepository::class);
        $this->app->bind(ProcessingFeeRepositoryInterface::class,ProcessingFeeRepository::class);
        $this->app->bind(AttendanceRepositoryInterface::class,AttendanceRepository::class);
        $this->app->bind(SubjectRepositoryInterface::class,SubjectRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class,QuestionRepository::class);
        $this->app->bind(QuizzRepositoryInterface::class,QuizzRepository::class);
        $this->app->bind(LibraryRepositoryInterface::class,LibraryRepository::class);
     
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
