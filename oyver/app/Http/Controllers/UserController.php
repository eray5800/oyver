<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

  public function login(){
        return view('users.login');
  }
  public function register() {
    
        return view('users.signup');
  }

  public function create(Request $request){
    $formFields = $request->validate([
        'name' => ['required', 'min:3','max:70',Rule::unique('users', 'name')],
        'email' => ['required','max:120', 'email', Rule::unique('users', 'email')],
        'password' => ['required','max:100', 'confirmed', 'min:6'],
        'profilepicture' => ['file', 'mimes:jpeg,png', 'image', 'max:5000'], // 5MB sınırı
        ], [
        'name.required' => 'Kullanıcı adı alanı zorunludur.',
        'name.unique' => 'Bu Kullanıcı adı zaten kullanımda.',
        'name.min' => 'Kullanıcı adı en az :min karakter olmalıdır.',
        'name.max' => 'Kullanıcı adı en fazla :max karakter olabilir.',
        'email.required' => 'E-posta alanı zorunludur.',
        'email.email' => 'Lütfen geçerli bir e-posta adresi giriniz.',
        'email.unique' => 'Bu e-posta adresi zaten kullanımda.',
        'email.max' => 'E-posta en fazla :max karakter olabilir.',
        'password.required' => 'Şifre alanı zorunludur.',
        'password.confirmed' => 'Şifreler uyuşmamaktadır.',
        'password.min' => 'Şifre en az :min karakter olmalıdır.',
        'password.max' => 'Şifre en fazla :max karakter olabilir.',
        'profilepicture.file' => 'Yüklenen dosya bir dosya değil.',
        'profilepicture.mimes' => 'Profil resmi olarak sadece jpeg ve png dosyaları kabul edilmektedir.',
        'profilepicture.image' => 'Yüklenen dosya bir resim dosyası değil.',
        'profilepicture.max' => 'Profil resmi en fazla 5MB olabilir.'
        ]);
            
            
    
       
        $formFields['password'] = bcrypt($formFields['password']);
    
        if($request->hasFile('profilepicture')){
            $formFields['profilepicture'] = $request->file('profilepicture')->store('profilepictures','public');
        }
       $user =  User::create($formFields);
        auth()->login($user);
    
        return redirect('/')->with('message','Kullanıcı yaratıldı ve hesaba giriş yapıldı.');
    }

    public function logout(Request $request){  
            auth()->logout();
        
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        
            return redirect("/")->with('message','Başarıyla çıkış yaptınız.');
    }

   public function  authenticate(Request $request){
   
        $formFields = $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ],[
            'email.required' => 'E-posta zorunludur.',
            'email.email' => 'Lütfen geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Şifre zorunludur.'
        ]);
    
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/')->with('message','Başarıyla giriş yapıldı.'); 
        }
        return back()->withErrors(['email'=>'Geçersiz üyelik bilgileri.'])->onlyInput('email');
    }

    


  
  
}
