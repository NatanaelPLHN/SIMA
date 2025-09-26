    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
    public function up(): void
    {
        Schema::create('aset', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama_aset');
            $table->enum('jenis_aset', ['bergerak', 'tidak_bergerak', 'habis_pakai']);
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete(); 
            $table->integer('jumlah')->default(1);
            $table->date('tgl_pembelian')->nullable();
            $table->decimal('nilai_pembelian', 15, 2)->nullable();
            $table->string('lokasi_terakhir')->nullable();
            $table->enum('status', ['tersedia','dipakai','rusak','hilang','habis'])->default('tersedia');
            $table->timestamps();
        });
    }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('aset');
        }
    };
