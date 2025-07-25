const C3 = self.C3;
self.C3_GetObjectRefTable = function () {
	return [
		C3.Plugins.Sprite,
		C3.Behaviors.Rotate,
		C3.Behaviors.Fade,
		C3.Behaviors.Sin,
		C3.Plugins.Audio,
		C3.Plugins.Browser,
		C3.Plugins.Keyboard,
		C3.Plugins.Mouse,
		C3.Plugins.Touch,
		C3.Plugins.LocalStorage,
		C3.Behaviors.Pin,
		C3.Behaviors.Flash,
		C3.Behaviors.Platform,
		C3.Behaviors.scrollto,
		C3.Behaviors.solid,
		C3.Plugins.TiledBg,
		C3.Behaviors.Bullet,
		C3.Plugins.Spritefont2,
		C3.Plugins.PlatformInfo,
		C3.Plugins.System.Cnds.OnLayoutStart,
		C3.Behaviors.Pin.Acts.Pin,
		C3.Plugins.Sprite.Acts.SetAnimFrame,
		C3.Plugins.System.Exps.random,
		C3.Plugins.System.Acts.SetVar,
		C3.Plugins.Sprite.Acts.SetPos,
		C3.Plugins.System.Cnds.IsGroupActive,
		C3.Plugins.Touch.Cnds.OnTouchObject,
		C3.Plugins.Keyboard.Cnds.OnAnyKey,
		C3.Behaviors.Sin.Cnds.IsEnabled,
		C3.Plugins.System.Cnds.CompareVar,
		C3.Plugins.Audio.Acts.Play,
		C3.Behaviors.Fade.Acts.StartFade,
		C3.Behaviors.Sin.Acts.SetEnabled,
		C3.Plugins.Sprite.Cnds.OnDestroyed,
		C3.Plugins.Sprite.Acts.SetAnim,
		C3.Plugins.System.Cnds.EveryTick,
		C3.Plugins.Spritefont2.Acts.SetText,
		C3.Behaviors.Bullet.Acts.SetEnabled,
		C3.Plugins.Sprite.Acts.SetY,
		C3.Plugins.Sprite.Exps.Y,
		C3.Plugins.Sprite.Cnds.IsBoolInstanceVarSet,
		C3.Plugins.System.Cnds.Every,
		C3.Plugins.System.Acts.AddVar,
		C3.Plugins.System.Acts.SubVar,
		C3.Plugins.Sprite.Cnds.OnAnyAnimFinished,
		C3.Plugins.Sprite.Acts.Destroy,
		C3.Behaviors.Platform.Cnds.IsOnFloor,
		C3.Plugins.Sprite.Cnds.IsAnimPlaying,
		C3.Behaviors.Platform.Acts.SimulateControl,
		C3.Behaviors.Platform.Acts.SetMaxSpeed,
		C3.Behaviors.Platform.Exps.MaxSpeed,
		C3.Plugins.Sprite.Cnds.OnCollision,
		C3.Plugins.System.Acts.Wait,
		C3.Plugins.Sprite.Acts.SetBoolInstanceVar,
		C3.Plugins.Sprite.Acts.Spawn,
		C3.Plugins.Sprite.Cnds.OnAnimFinished,
		C3.Plugins.Sprite.Cnds.CompareX,
		C3.Behaviors.scrollto.Acts.Shake,
		C3.Behaviors.Flash.Acts.Flash,
		C3.Plugins.System.Acts.CreateObject,
		C3.Plugins.System.Exps.viewportright,
		C3.Plugins.System.Exps.viewportbottom,
		C3.Plugins.LocalStorage.Acts.SetItem,
		C3.Plugins.System.Exps.projectname,
		C3.Plugins.System.Acts.SetGroupActive,
		C3.Plugins.System.Acts.WaitForSignal,
		C3.ScriptsInEvents.Game_events_Event54_Act3,
		C3.ScriptsInEvents.Game_events_Event54_Act4,
		C3.Plugins.System.Acts.GoToLayout,
		C3.Plugins.Sprite.Acts.MoveToBottom,
		C3.Plugins.Sprite.Exps.X,
		C3.Plugins.Sprite.Cnds.CompareFrame,
		C3.Plugins.Sprite.Acts.SetInstanceVar,
		C3.Plugins.Sprite.Cnds.CompareY,
		C3.Plugins.TiledBg.Cnds.CompareX,
		C3.Plugins.TiledBg.Exps.Width,
		C3.Plugins.TiledBg.Acts.SetX,
		C3.Plugins.TiledBg.Exps.X,
		C3.Plugins.PlatformInfo.Cnds.IsOnMobile,
		C3.Plugins.Browser.Acts.RequestFullScreen,
		C3.Plugins.System.Acts.SetLayerOpacity,
		C3.Plugins.System.Acts.SetTimescale,
		C3.Plugins.LocalStorage.Acts.CheckItemExists,
		C3.Plugins.Spritefont2.Cnds.CompareInstanceVar,
		C3.Plugins.LocalStorage.Cnds.OnItemMissing,
		C3.Plugins.LocalStorage.Cnds.OnItemExists,
		C3.Plugins.LocalStorage.Acts.GetItem,
		C3.Plugins.LocalStorage.Exps.ItemValue,
		C3.Plugins.Touch.Cnds.OnTapGestureObject,
		C3.Plugins.Audio.Acts.SetSilent,
		C3.Plugins.Audio.Acts.SetMasterVolume,
		C3.Plugins.System.Acts.RestartLayout,
		C3.Plugins.Mouse.Cnds.IsButtonDown,
		C3.Plugins.Mouse.Acts.SetCursorSprite,
		C3.Plugins.System.Cnds.Else,
		C3.Plugins.Mouse.Cnds.IsOverObject,
		C3.Plugins.Sprite.Acts.SetSize,
		C3.Plugins.Sprite.Cnds.CompareAnimSpeed,
		C3.Plugins.Sprite.Acts.StopAnim,
		C3.Behaviors.Platform.Acts.SetEnabled,
		C3.Plugins.Sprite.Acts.StartAnim,
		C3.Plugins.System.Cnds.TriggerOnce,
		C3.Plugins.System.Acts.SetLayerScale,
		C3.Plugins.System.Exps.layeropacity,
		C3.Plugins.System.Exps.layerscale,
		C3.Plugins.System.Cnds.LayerCmpOpacity,
		C3.Plugins.System.Acts.Signal,
		C3.Plugins.Audio.Acts.StopAll
	];
};
self.C3_JsPropNameTable = [
	{Cursor: 0},
	{CursorHover: 0},
	{Rotate: 0},
	{SunLight: 0},
	{FramePaused: 0},
	{TextPaused: 0},
	{Fade: 0},
	{TextTapToPlay: 0},
	{TextGameOver: 0},
	{TextGameResults: 0},
	{DistancesGui: 0},
	{FramesGui: 0},
	{GuiScore: 0},
	{GuiTime: 0},
	{LivesGui: 0},
	{Background: 0},
	{Sine: 0},
	{GameLogo: 0},
	{TouchArea: 0},
	{Audio: 0},
	{Browser: 0},
	{Keyboard: 0},
	{Mouse: 0},
	{Touch: 0},
	{LocalStorage: 0},
	{Pin: 0},
	{Flash: 0},
	{Player: 0},
	{Platform: 0},
	{ScrollTo: 0},
	{PlayerCollision: 0},
	{Solid: 0},
	{GroundsDown: 0},
	{GroundsTop: 0},
	{Bullet: 0},
	{Water: 0},
	{GroundCollision: 0},
	{Toched: 0},
	{Box: 0},
	{ID: 0},
	{Bomb: 0},
	{Spikes: 0},
	{LastScoreFont: 0},
	{LivesFont: 0},
	{BestScoreFont: 0},
	{ScoreFont: 0},
	{TimeFont: 0},
	{MusicFont: 0},
	{SoundFont: 0},
	{LoadingFont: 0},
	{InfoFont: 0},
	{GameOverFont: 0},
	{DistancesFont: 0},
	{BtnExit: 0},
	{BtnPlay: 0},
	{BtnMenu: 0},
	{BtnMusic: 0},
	{BtnPause: 0},
	{BtnReload: 0},
	{BtnReturn: 0},
	{BtnGo: 0},
	{BtnRestart: 0},
	{BtnSpeed: 0},
	{Explosion: 0},
	{Coin: 0},
	{Gold: 0},
	{Star: 0},
	{Ring: 0},
	{Jewel: 0},
	{Dust: 0},
	{Bird: 0},
	{Flame: 0},
	{Clouds: 0},
	{Score_10: 0},
	{Score_100: 0},
	{Score_25: 0},
	{Score_5: 0},
	{Score_50: 0},
	{PlatformInfo: 0},
	{Buttons: 0},
	{TextFonts: 0},
	{Objects: 0},
	{Treasures: 0},
	{Scores: 0},
	{Trails: 0},
	{Trails_Type: 0},
	{Game_Speed: 0},
	{Distances: 0},
	{Jump: 0},
	{Score: 0},
	{Lives: 0},
	{Seconds: 0},
	{Minutes: 0},
	{Last_Score: 0},
	{Best_Score: 0},
	{Count_Score: 0},
	{Pause: 0},
	{SoundC: 0}
];

self.InstanceType = {
	Cursor: class extends self.ISpriteInstance {},
	CursorHover: class extends self.ISpriteInstance {},
	SunLight: class extends self.ISpriteInstance {},
	FramePaused: class extends self.ISpriteInstance {},
	TextPaused: class extends self.ISpriteInstance {},
	TextTapToPlay: class extends self.ISpriteInstance {},
	TextGameOver: class extends self.ISpriteInstance {},
	TextGameResults: class extends self.ISpriteInstance {},
	DistancesGui: class extends self.ISpriteInstance {},
	FramesGui: class extends self.ISpriteInstance {},
	GuiScore: class extends self.ISpriteInstance {},
	GuiTime: class extends self.ISpriteInstance {},
	LivesGui: class extends self.ISpriteInstance {},
	Background: class extends self.ISpriteInstance {},
	GameLogo: class extends self.ISpriteInstance {},
	TouchArea: class extends self.ISpriteInstance {},
	Audio: class extends self.IInstance {},
	Browser: class extends self.IInstance {},
	Keyboard: class extends self.IInstance {},
	Mouse: class extends self.IInstance {},
	Touch: class extends self.IInstance {},
	LocalStorage: class extends self.IInstance {},
	Player: class extends self.ISpriteInstance {},
	PlayerCollision: class extends self.ISpriteInstance {},
	GroundsDown: class extends self.ISpriteInstance {},
	GroundsTop: class extends self.ISpriteInstance {},
	Water: class extends self.ITiledBackgroundInstance {},
	GroundCollision: class extends self.ISpriteInstance {},
	Box: class extends self.ISpriteInstance {},
	Bomb: class extends self.ISpriteInstance {},
	Spikes: class extends self.ISpriteInstance {},
	LastScoreFont: class extends self.ISpriteFontInstance {},
	LivesFont: class extends self.ISpriteFontInstance {},
	BestScoreFont: class extends self.ISpriteFontInstance {},
	ScoreFont: class extends self.ISpriteFontInstance {},
	TimeFont: class extends self.ISpriteFontInstance {},
	MusicFont: class extends self.ISpriteFontInstance {},
	SoundFont: class extends self.ISpriteFontInstance {},
	LoadingFont: class extends self.ISpriteFontInstance {},
	InfoFont: class extends self.ISpriteFontInstance {},
	GameOverFont: class extends self.ISpriteFontInstance {},
	DistancesFont: class extends self.ISpriteFontInstance {},
	BtnExit: class extends self.ISpriteInstance {},
	BtnPlay: class extends self.ISpriteInstance {},
	BtnMenu: class extends self.ISpriteInstance {},
	BtnMusic: class extends self.ISpriteInstance {},
	BtnPause: class extends self.ISpriteInstance {},
	BtnReload: class extends self.ISpriteInstance {},
	BtnReturn: class extends self.ISpriteInstance {},
	BtnGo: class extends self.ISpriteInstance {},
	BtnRestart: class extends self.ISpriteInstance {},
	BtnSpeed: class extends self.ISpriteInstance {},
	Explosion: class extends self.ISpriteInstance {},
	Coin: class extends self.ISpriteInstance {},
	Gold: class extends self.ISpriteInstance {},
	Star: class extends self.ISpriteInstance {},
	Ring: class extends self.ISpriteInstance {},
	Jewel: class extends self.ISpriteInstance {},
	Dust: class extends self.ISpriteInstance {},
	Bird: class extends self.ISpriteInstance {},
	Flame: class extends self.ISpriteInstance {},
	Clouds: class extends self.ISpriteInstance {},
	Score_10: class extends self.ISpriteInstance {},
	Score_100: class extends self.ISpriteInstance {},
	Score_25: class extends self.ISpriteInstance {},
	Score_5: class extends self.ISpriteInstance {},
	Score_50: class extends self.ISpriteInstance {},
	PlatformInfo: class extends self.IInstance {},
	Buttons: class extends self.ISpriteInstance {},
	TextFonts: class extends self.ISpriteInstance {},
	Objects: class extends self.ISpriteInstance {},
	Treasures: class extends self.ISpriteInstance {},
	Scores: class extends self.ISpriteInstance {}
}